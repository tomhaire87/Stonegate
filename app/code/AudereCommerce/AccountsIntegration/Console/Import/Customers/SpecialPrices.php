<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import\Customers;

use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\AccountsIntegration\Helper\Factor as FactorHelper;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\CustomerSpecialPriceRepositoryInterface as KamarinCustomerSpecialPriceRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\QuantityBreakSpecialPriceRepositoryInterface as KamarinQuantityBreakSpecialPriceRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Logger\Monolog;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpecialPrices extends AbstractConsole
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
     * @var FactorHelper
     */
    protected $_factorHelper;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var KamarinCustomerSpecialPriceRepositoryInterface
     */
    protected $_kamarinCustomerSpecialPriceRepository;

    /**
     * @var KamarinQuantityBreakSpecialPriceRepositoryInterface
     */
    protected $_kamarinQuantityBreakSpecialPriceRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var AccountRepositoryInterface
     */
    protected $_accountRepository;

    /**
     * @var Monolog
     */
    protected $_logger;

    /**
     * @var array
     */
    protected $_accountPriceLists = array();

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        FactorHelper $factorHelper,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        KamarinCustomerSpecialPriceRepositoryInterface $kamarinCustomerSpecialPriceRepository,
        KamarinQuantityBreakSpecialPriceRepositoryInterface $kamarinQuantityBreakSpecialPriceRepository,
        ProductRepositoryInterface $productRepository,
        AccountRepositoryInterface $accountRepository,
        Monolog $logger
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_factorHelper = $factorHelper;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_kamarinCustomerSpecialPriceRepository = $kamarinCustomerSpecialPriceRepository;
        $this->_kamarinQuantityBreakSpecialPriceRepository = $kamarinQuantityBreakSpecialPriceRepository;
        $this->_productRepository = $productRepository;
        $this->_accountRepository = $accountRepository;
        $this->_logger = $logger;

        parent::__construct('auderecommerce:accountsintegration:import:customers:special-prices');
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

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/price')) {
            $this->log("Customer price importing is not enabled");
        } else {
            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->create();

            $searchResults = $this->_accountRepository->getList($searchCriteria);

            foreach ($searchResults->getItems() as $account) {
                $this->_accountPriceLists[$account->getPriceList()][$account->getCustomerGroupId()] = $account->getCustomerGroupId();
            }

            $this->_importCustomerSpecialPrices();
            $this->_importQuantityBreakSpecialPrices();
        }

        $this->_emulation->stopEnvironmentEmulation();

        return $this;
    }

    protected function _importCustomerSpecialPrices()
    {
        $searchCriteria = $this->_searchCriteriaBuilderFactory
            ->create()
            ->addFilter('record_updated', 1)
            ->create();

        $searchResults = $this->_kamarinCustomerSpecialPriceRepository->getList($searchCriteria);
        $customerSpecialPrices = $searchResults->getItems();

        $t = count($customerSpecialPrices);
        $i = 0;

        if ($t <= 0) {
            $this->log("No customer special prices to import");
        } else {
            $tierPricesBySku = array();
            $this->log("Grouping {$t} customer special prices");

            foreach ($customerSpecialPrices as $customerSpecialPrice) {
                $i++;
                $specialPriceId = $customerSpecialPrice->getSpecialPriceId();
                $stockCode = $customerSpecialPrice->getStockCode();
                $this->log("Customer special price {$i}/{$t} (ID: {$specialPriceId})");

                try {
                    if (empty($customerSpecialPrice->getPriceListCode())) {
                        continue;
                    }

                    if (!isset($this->_accountPriceLists[$customerSpecialPrice->getPriceListCode()])) {
                        continue;
                    }

                    foreach ($this->_accountPriceLists[$customerSpecialPrice->getPriceListCode()] as $customerGroupId) {
                        $tierPricesBySku[$stockCode][] = array(
                            'cust_group' => $customerGroupId,
                            'price' => $customerSpecialPrice->getSpecialPrice(),
                            'qty' => 1
                        );
                    }

                    $customerSpecialPrice->setRecordUpdated(0);
                    $this->_kamarinCustomerSpecialPriceRepository->save($customerSpecialPrice);
                } catch (\Exception $exception) {
                    $this->log($exception);
                    $this->_logger->addError($exception);
                }
            }

            $t = count($tierPricesBySku);
            $i = 0;
            $this->log("Saving {$t} product tier prices (customer special prices)");

            foreach ($tierPricesBySku as $stockCode => $tierPrices) {
                $i++;
                $this->log("Product tier price {$i}/{$t} (Stock Code: {$stockCode})");

                try {
                    try {
                        $product = $this->_productRepository->get($stockCode, array('edit_mode' => true));
                    } catch (NoSuchEntityException $exception) {
                        continue;
                    }

                    foreach ($tierPrices as &$tierPrice) {
                        if ($this->_factorHelper->isFactorEnabled()) {
                            $factor = $this->_factorHelper->getProductFactor($product);
                            $tierPrice['price'] = $this->_factorHelper->getImportPrice($tierPrice['price'], $factor);
                        }
                    }

                    $this->_saveTierPrices($product, $tierPrices);
                } catch (\Exception $exception) {
                    $this->log($exception);
                    $this->_logger->addError($exception);
                }
            }
        }
    }

    protected function _importQuantityBreakSpecialPrices()
    {
        $searchCriteria = $this->_searchCriteriaBuilderFactory
            ->create()
            ->addFilter('record_updated', 1)
            ->create();

        $searchResults = $this->_kamarinQuantityBreakSpecialPriceRepository->getList($searchCriteria);
        $quantityBreakSpecialPrices = $searchResults->getItems();

        $t = count($quantityBreakSpecialPrices);
        $i = 0;

        if ($t <= 0) {
            $this->log("No quantity break special prices to import");
        } else {
            $tierPricesBySku = array();
            $this->log("Grouping {$t} quantity break special prices");

            foreach ($quantityBreakSpecialPrices as $quantityBreakSpecialPrice) {
                $i++;
                $qtyBreakPriceId = $quantityBreakSpecialPrice->getQtyBreakPriceId();
                $stockCode = $quantityBreakSpecialPrice->getStockCode();
                $this->log("Quantity break special price {$i}/{$t} (ID: {$qtyBreakPriceId})");

                try {
                    if (empty($quantityBreakSpecialPrice->getPriceListCode())) {
                        continue;
                    }

                    if (!isset($this->_accountPriceLists[$quantityBreakSpecialPrice->getPriceListCode()])) {
                        continue;
                    }

                    foreach ($this->_accountPriceLists[$quantityBreakSpecialPrice->getPriceListCode()] as $customerGroupId) {
                        $tierPricesBySku[$stockCode][] = array(
                            'cust_group' => $customerGroupId,
                            'price' => $quantityBreakSpecialPrice->getSpecialPrice(),
                            'qty' => max($quantityBreakSpecialPrice->getFromQty(), 1)
                        );
                    }

                    $quantityBreakSpecialPrice->setRecordUpdated(0);
                    $this->_kamarinQuantityBreakSpecialPriceRepository->save($quantityBreakSpecialPrice);
                } catch (\Exception $exception) {
                    $this->log($exception);
                    $this->_logger->addError($exception);
                }
            }

            $t = count($tierPricesBySku);
            $i = 0;
            $this->log("Saving {$t} product tier prices (quantity break special prices)");

            foreach ($tierPricesBySku as $stockCode => $tierPrices) {
                $i++;
                $this->log("Product tier price {$i}/{$t} (Stock Code: {$stockCode})");

                try {
                    try {
                        $product = $this->_productRepository->get($stockCode, array('edit_mode' => true));
                    } catch (NoSuchEntityException $exception) {
                        continue;
                    }

                    foreach ($tierPrices as &$tierPrice) {
                        if ($this->_factorHelper->isFactorEnabled()) {
                            $factor = $this->_factorHelper->getProductFactor($product);
                            $tierPrice['price'] = $this->_factorHelper->getImportPrice($tierPrice['price'], $factor);
                        }
                    }

                    $this->_saveTierPrices($product, $tierPrices);
                } catch (\Exception $exception) {
                    $this->log($exception);
                    $this->_logger->addError($exception);
                }
            }
        }
    }

    protected function _saveTierPrices(ProductInterface $product, array $newTierPrices)
    {
        $tierPrices = $product->getData('tier_price');

        $websiteIdentifier = 0;

        if ($this->_scopeConfig->getValue('catalog/price/scope', \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE) != 0) {
            $websiteIdentifier = $this->storeManager->getWebsite()->getId();
        }

        foreach ($newTierPrices as $newTierPrice) {
            $found = false;

            foreach ($tierPrices as &$item) {
                if ($item['cust_group'] == $newTierPrice['cust_group']
                    && $item['website_id'] == $websiteIdentifier
                    && $item['price_qty'] == $newTierPrice['qty']) {
                    $item['price'] = $newTierPrice['price'];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $tierPrices[] = array(
                    'cust_group' => $newTierPrice['cust_group'],
                    'price' => $newTierPrice['price'],
                    'website_price' => $newTierPrice['price'],
                    'website_id' => $websiteIdentifier,
                    'price_qty' => $newTierPrice['qty']
                );
            }
        }

        $product->setData('tier_price', $tierPrices);
        $errors = $product->validate();

        if (is_array($errors) && count($errors)) {
            $errorAttributeCodes = implode(', ', array_keys($errors));
            throw new InputException(
                __('Values of following attributes are invalid: %1', $errorAttributeCodes)
            );
        }

        $this->_productRepository->save($product);
    }

}