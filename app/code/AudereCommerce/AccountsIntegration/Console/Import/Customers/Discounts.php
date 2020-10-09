<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import\Customers;

use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockRecordRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;
use Magento\CatalogRule\Model\FlagFactory;
use Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory as CatalogRuleCollectionFactory;
use Magento\CatalogRule\Model\Rule\Job as RuleJob;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as GroupCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Logger\Monolog;
use Magento\Store\Model\App\Emulation;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Discounts extends AbstractConsole
{

    /**
     * @var Emulation
     */
    protected $_emulation;

    /**
     * @var State
     */
    protected $_state;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var Monolog
     */
    protected $_logger;

    /**
     * @var ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var StockRecordRepositoryInterface
     */
    protected $_stockRecordRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var CatalogRuleRepositoryInterface
     */
    protected $_catalogRuleRepository;

    /**
     * @var CatalogRuleCollectionFactory
     */
    protected $_catalogRuleCollectionFactory;

    /**
     * @var CustomerCollectionFactory
     */
    protected $_customerCollectionFactory;

    /**
     * @var GroupCollectionFactory
     */
    protected $_groupCollectionFactory;

    /**
     * @var FlagFactory
     */
    protected $_flagFactory;

    /**
     * @var RuleJob
     */
    protected $_ruleJob;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        Monolog $logger,
        ResourceConnection $resourceConnection,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        StockRecordRepositoryInterface $stockRecordRepository,
        ProductRepositoryInterface $productRepository,
        CatalogRuleRepositoryInterface $catalogRuleRepository,
        CatalogRuleCollectionFactory $catalogRuleCollectionFactory,
        CustomerCollectionFactory $customerCollectionFactory,
        GroupCollectionFactory $groupCollectionFactory,
        FlagFactory $flagFactory,
        RuleJob $ruleJob,
        StoreManagerInterface $storeManager
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_logger = $logger;
        $this->_resourceConnection = $resourceConnection;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_stockRecordRepository = $stockRecordRepository;
        $this->_productRepository = $productRepository;
        $this->_catalogRuleRepository = $catalogRuleRepository;
        $this->_catalogRuleCollectionFactory = $catalogRuleCollectionFactory;
        $this->_customerCollectionFactory = $customerCollectionFactory;
        $this->_groupCollectionFactory = $groupCollectionFactory;
        $this->_flagFactory = $flagFactory;
        $this->_ruleJob = $ruleJob;
        $this->_storeManager = $storeManager;

        parent::__construct('auderecommerce:accountsintegration:import:customers:discounts');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        try {
            $this->_state->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_state->setAreaCode(\Magento\Backend\App\Area\FrontNameResolver::AREA_CODE);
        }

        $this->_emulation->startEnvironmentEmulation(\Magento\Store\Model\Store::DEFAULT_STORE_ID, \Magento\Framework\App\Area::AREA_ADMINHTML);

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/discount')) {
            $this->log("Customer discount importing is not enabled");
        } else {
            $connection = $this->_resourceConnection->getConnection('kamarin_ecommerce_link');
            $magentoConnection = $this->_resourceConnection->getConnection();

            $select = $connection
                ->select()
                ->from(array('sd' => $connection->getTableName('stock_discounts')), array('stock_discount_id', 'customer_code', 'discount_code', 'discount'))
                ->where('sd.record_updated = ?', 1);

            $stockDiscounts = $connection->fetchAll($select);
            $stockDiscountCount = count($stockDiscounts);

            if ($stockDiscountCount <= 0) {
                $this->log("No customer discounts to import");
            } else {
                $this->log("Importing {$stockDiscountCount} customer discounts");
                $updatedStockIds = array();
                $i = 0;

                $websiteIds = array();

                foreach ($this->_storeManager->getWebsites() as $website) {
                    $websiteIds[] = $website->getId();
                }

                $customerGroups = array();

                foreach ($this->_groupCollectionFactory->create() as $customerGroup) {
                    $customerGroups[$customerGroup->getCustomerGroupCode()] = $customerGroup->getId();
                }

                $customerCodesByDiscountCode = array();

                foreach ($this->_customerCollectionFactory->create() as $customer) {
                    $discountCode = trim($customer->getDiscountCode());

                    if (!empty($discountCode) || $discountCode === '0') {
                        $customerCodesByDiscountCode[$discountCode][] = $customer->getAccountCode();
                    }
                }

                foreach ($stockDiscounts as $stockDiscount) {
                    try {
                        $i++;

                        $stockDiscountId = $stockDiscount['stock_discount_id'];
                        $customerDiscountCode = trim($stockDiscount['customer_code']);
                        $discountCode = trim($stockDiscount['discount_code']);
                        $discount = $stockDiscount['discount'];

                        $this->log("Customer discount {$i}/{$stockDiscountCount} (ID: {$stockDiscountId})");

                        $accountCodes = array();

                        if (array_key_exists($customerDiscountCode, $customerGroups)) {
                            $accountCodes[] = $customerDiscountCode;
                        } elseif (isset($customerCodesByDiscountCode[$customerDiscountCode])) {
                            $accountCodes = $customerCodesByDiscountCode[$customerDiscountCode];
                        }

                        if (empty($accountCodes)) {
                            throw new \Exception("No customers found in Stock Discount $stockDiscountId");
                        }

                        $customerGroupIds = array();

                        foreach ($accountCodes as $customerCode) {
                            if (isset($customerGroups[$customerCode])) {
                                $customerGroupId = $customerGroups[$customerCode];
                                $customerGroupIds[$customerGroupId] = $customerGroupId;
                            }
                        }

                        if (empty($customerGroupIds)) {
                            throw new \Exception("No matching account codes found in Stock Discount $stockDiscountId");
                        }

                        $skus = array();

                        if (!empty($discountCode)) {

                            $searchCriteria = $this->_searchCriteriaBuilderFactory
                                ->create()
                                ->addFilter('discount_code', $discountCode)
                                ->create();

                            $searchResults = $this->_stockRecordRepository->getList($searchCriteria);

                            foreach ($searchResults->getItems() as $stockRecord) {
                                if ($stockCode = trim($stockRecord->getStockCode())) {
                                    try {
                                        $product = $this->_productRepository->get($stockCode);
                                        $skus[$product->getId()] = $product->getSku();
                                    } catch (NoSuchEntityException $exception) {
                                    }
                                }
                            }

                            if (empty($skus)) {
                                throw new \Exception("No products found in Stock Discount $stockDiscountId");
                            }
                        }

                        $rule = $this->_catalogRuleCollectionFactory
                            ->create()
                            ->addFilter('name', "Stock Discount (ID: $stockDiscountId)")
                            ->getFirstItem();

                        $rule->setName("Stock Discount (ID: $stockDiscountId)");
                        $rule->setIsActive(true);
                        $rule->setWebsiteIds($websiteIds);
                        $rule->setCustomerGroupIds($customerGroupIds);
                        $rule->setDiscountAmount($discount);
                        $rule->setSimpleAction('by_percent');
                        $rule->setFromDate('');
                        $rule->setToDate('');
                        $rule->setStopRulesProcessing(0);

                        $this->_catalogRuleRepository->save($rule);

                        $conditionsSerialized = null;
                        if (!empty($skus)) {

                            $conditionsSerialized = json_encode(array(
                                'type' => 'Magento\\CatalogRule\\Model\\Rule\\Condition\\Combine',
                                'attribute' => null,
                                'operator' => null,
                                'value' => '1',
                                'is_value_processed' => null,
                                'aggregator' => 'all',
                                'conditions' => array(
                                    array(
                                        'type' => 'Magento\\CatalogRule\\Model\\Rule\\Condition\\Product',
                                        'attribute' => 'sku',
                                        'operator' => '()',
                                        'value' => implode(', ', $skus),
                                        'is_value_processed' => false,
                                    )
                                )
                            ));
                        }

                        $magentoConnection->update(
                            $connection->getTableName('catalogrule'),
                            array('conditions_serialized' => $conditionsSerialized),
                            array('rule_id = ?' => $rule->getId())
                        );

                        $updatedStockIds[$stockDiscountId] = $stockDiscountId;
                    } catch (\Exception $exception) {
                        $this->log($exception);
                        $this->_logger->addError($exception);
                    }
                }

                $this->log("Updating stock discounts in kamarin");

                try {
                    if (!empty($updatedStockIds)) {
                        $connection->update(
                            $connection->getTableName('stock_discounts'),
                            array('record_updated' => 0),
                            array('stock_discount_id IN (?)' => $updatedStockIds)
                        );

                        $this->_ruleJob->applyAll();

                        if ($this->_ruleJob->hasError()) {
                            throw new \Exception($this->_ruleJob->getError());
                        }

                        $this->_flagFactory->create()->loadSelf()->setState(0)->save();
                    }
                } catch (\Exception $exception) {
                    $this->log($exception);
                    $this->_logger->addError($exception);
                }
            }
        }

        $this->_emulation->stopEnvironmentEmulation();

        return $this;
    }

}