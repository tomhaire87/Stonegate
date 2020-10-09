<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import;

use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\AccountsIntegration\Helper\Factor as FactorHelper;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\CustomerRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockRecordRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductAttributeOptionManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\ProductTierPriceManagementInterface;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Eav\Model\Entity\Attribute\OptionFactory as OptionFactory;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Logger\Monolog;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Products extends AbstractConsole
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
     * @var StockRecordRepositoryInterface
     */
    protected $_stockRecordRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var GroupRepositoryInterface
     */
    protected $_groupRepository;

    /*
     *
     */
    protected $_productTierPriceManagement;

    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    /**
     * @var ProductResource
     */
    protected $_productResource;

    /**
     * @var ProductAttributeOptionManagementInterface
     */
    protected $_productAttributeOptionManagement;

    /**
     * @var AttributeOptionManagementInterface
     */
    protected $_attributeOptionManagement;

    /**
     * @var OptionFactory
     */
    protected $_optionFactory;

    /**
     * @var StockRegistryInterface
     */
    protected $_stockRegistry;

    /**
     * @var Monolog
     */
    protected $_logger;

    /**
     * @var ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * @var array
     */
    protected $_customImportAttributes = array();

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        FactorHelper $factorHelper,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        StockRecordRepositoryInterface $stockRecordRepository,
        ProductRepositoryInterface $productRepository,
        CustomerRepositoryInterface $customerRepository,
        GroupRepositoryInterface $groupRepository,
        ProductTierPriceManagementInterface $productTierPriceManagement,
        ProductFactory $productFactory,
        ProductResource $productResource,
        ProductAttributeOptionManagementInterface $productAttributeOptionManagement,
        AttributeOptionManagementInterface $attributeOptionManagement,
        OptionFactory $optionFactory,
        StockRegistryInterface $stockRegistry,
        Monolog $logger,
        ResourceConnection $resourceConnection
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_factorHelper = $factorHelper;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_stockRecordRepository = $stockRecordRepository;
        $this->_productRepository = $productRepository;
        $this->_customerRepository = $customerRepository;
        $this->_groupRepository = $groupRepository;
        $this->_productTierPriceManagement = $productTierPriceManagement;
        $this->_productFactory = $productFactory;
        $this->_productResource = $productResource;
        $this->_productAttributeOptionManagement = $productAttributeOptionManagement;
        $this->_attributeOptionManagement = $attributeOptionManagement;
        $this->_optionFactory = $optionFactory;
        $this->_stockRegistry = $stockRegistry;
        $this->_logger = $logger;
        $this->_resourceConnection = $resourceConnection;

        parent::__construct('auderecommerce:accountsintegration:import:products');
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

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/product/create')) {
            $this->log("Product importing is not enabled");
        } else {
            $stockRecords = $this->_getStockRecords();
            $totalStockRecords = count($stockRecords);
            $currentRecordCount = 0;

            if ($totalStockRecords <= 0) {
                $this->log("No products to import");
            } else {
                $this->log("Importing {$totalStockRecords} products");

                $customImportColumns = array(
                    'cost_price',
                    'unit_description',
                    'extended_description',
                    'user_field_1',
                    'user_field_2',
                    'user_field_3',
                    'user_field_4',
                    'user_field_5',
                    'user_field_6',
                    'user_field_7',
                    'user_field_8',
                    'user_field_9',
                    'user_field_10',
                    'featured_item',
                    'weight',
                    'search_ref_1',
                    'search_ref_2',
                    'meta_title',
                    'meta_keywords',
                    'custom_text_1',
                    'custom_text_2',
                    'custom_text_3',
                    'custom_date_1',
                    'custom_date_2'
                );

                foreach ($customImportColumns as $column) {
                    $attribute = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/product/update_attribute_' . $column);

                    if (!empty($attribute)) {
                        $this->_customImportAttributes[$column] = $attribute;
                    }
                }

                foreach ($stockRecords as $stockRecord) {
                    $currentRecordCount++;
                    $stockCode = $stockRecord->getStockCode();
                    $this->log("Product {$currentRecordCount}/{$totalStockRecords} (SKU: {$stockCode})");

                    try {
                        $this->_importAndUpdate($stockRecord);

                        $stockRecord->setRecordUpdated(0);
                        $this->_stockRecordRepository->save($stockRecord);
                    } catch (\Exception $exception) {
                        $this->log($exception);
                        $this->_logger->addError($exception);
                    }
                }
            }
        }

        $this->_emulation->stopEnvironmentEmulation();

        return $this;
    }

    protected function _getStockRecords()
    {
        $searchCriteria = $this->_searchCriteriaBuilderFactory
            ->create()
            ->addFilter('record_updated', '1')
            ->create();

        $searchResults = $this->_stockRecordRepository->getList($searchCriteria);

        return $searchResults->getItems();
    }

    protected function _importAndUpdate($stockRecord)
    {
        if (!empty($stockRecord->getStockCode())) {
            try {
                $product = $this->_productRepository->get($stockRecord->getStockCode());
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $product = $this->_importProduct($stockRecord);
            }

            if ($product instanceof ProductInterface) {
                $this->_updateProduct($stockRecord, $product);
            }
        }
    }

    protected function _importProduct(StockRecordInterface $stockRecord)
    {
        if (!$stockRecord->getNonSaleableOnWeb() && $this->_scopeConfig->getValue('auderecommerce_accountsintegration/product/create')) {
            $product = $this->_productFactory->create();

            $product
                ->setAttributeSetId($product->getDefaultAttributeSetId())
                ->setUrlKey($stockRecord->getStockCode())
                ->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE)
                ->setSku($stockRecord->getStockCode())
                ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE)
                ->setPrice($stockRecord->getSellPrice())
                ->setName($stockRecord->getDescription());

            $this->_productRepository->save($product);

            return $product;
        }

        return false;
    }

    protected function _updateProduct(StockRecordInterface $stockRecord, ProductInterface $product)
    {
        foreach ($this->_customImportAttributes as $stockRecordAttribute => $productAttribute) {
            if ($attributeValue = $stockRecord->getData($stockRecordAttribute)) {
                $attribute = $this->_productResource->getAttribute($productAttribute);
                $attributeInput = $attribute->getFrontendInput();

                if ($attributeInput == 'text' || $attributeInput == 'textarea') {
                    $product->setData($productAttribute, $attributeValue);
                } elseif ($attributeInput == 'select') {
                    $options = $attribute->getOptions();
                    $existingOption = array_filter($options, function ($option) use (&$attributeValue) {
                        /* @var $option \Magento\Eav\Api\Data\AttributeOptionInterface */
                        return ($option->getLabel() == $attributeValue);
                    });

                    if (empty($existingOption)) {
                        $newOption = $this->_optionFactory->create();
                        $newOption->setLabel($attributeValue);
                        $this->_productAttributeOptionManagement->add($attribute->getAttributeCode(), $newOption);

                        $updatedOptionItems = $this->_attributeOptionManagement->getItems(\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE, $attribute->getAttributeCode());
                        $updatedOptions = array_filter($updatedOptionItems, function ($updatedOption) use (&$attributeValue) {
                            /* @var $updatedOption \Magento\Eav\Api\Data\AttributeOptionInterface */
                            return ($updatedOption->getLabel() == $attributeValue);
                        });

                        if (!empty($updatedOptions)) {
                            $updatedOption = $updatedOptions[key($updatedOptions)];
                            $product->setData($attribute->getAttributeCode(), $updatedOption->getValue());

                        }
                    } else {
                        $existingOption = $existingOption[key($existingOption)];
                        $product->setData($attribute->getAttributeCode(), $existingOption->getValue());
                    }
                }
            }
        }

        if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/product/price')) {
            $sellPrice = $stockRecord->getSellPrice();

            if ($this->_factorHelper->isFactorEnabled()) {
                $factor = $this->_factorHelper->getProductFactor($product);
                $sellPrice = $this->_factorHelper->getImportPrice($sellPrice, $factor);
            }

            $product->setPrice($sellPrice);
        }

        if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/product/price_bands')) {
            $priceBands = array();

            foreach (array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H') as $priceBand) {
                $price = $stockRecord->getData('sell_price_' . strtolower($priceBand));

                if ($price > 0) {
                    $priceBands[$priceBand] = $price;
                }
            }

            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('price_band', array_keys($priceBands), 'in')
                ->create();

            $searchResults = $this->_customerRepository->getList($searchCriteria);

            $accountCodePrices = array();

            foreach ($searchResults->getItems() as $kamarinCustomer) {
                $accountCodePrices[$kamarinCustomer->getAccountCode()] = $priceBands[$kamarinCustomer->getPriceBand()];
            }

            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('customer_group_code', array_keys($accountCodePrices), 'in')
                ->create();

            $searchResults = $this->_groupRepository->getList($searchCriteria);

            foreach ($searchResults->getItems() as $customerGroup) {
                $customerGroupId = $customerGroup->getId();
                $price = $accountCodePrices[$customerGroup->getCode()];
                $this->_productTierPriceManagement->add($stockRecord->getStockCode(), $customerGroupId, $price, 1);
            }

            $connection = $this->_resourceConnection->getConnection('kamarin_ecommerce_link');

            $connection->update(
                $connection->getTableName('customer_special_prices'),
                array('record_updated' => 1),
                array('stock_code = ?' => $stockRecord->getStockCode())
            );

            $connection->update(
                $connection->getTableName('quantity_break_special_prices'),
                array('record_updated' => 1),
                array('stock_code = ?' => $stockRecord->getStockCode())
            );
        }

        if (!$stockRecord->getNonSaleableOnWeb() && $this->_scopeConfig->getValue('auderecommerce_accountsintegration/stock/import')) {
            $this->_updateProductStock($stockRecord, $product);
        }
		if($product->getName() != $stockRecord->getDescription()) {
			$product->setName($stockRecord->getDescription());
		}
        $product->setStatus($stockRecord->getNonSaleableOnWeb() ? Status::STATUS_DISABLED : Status::STATUS_ENABLED);

        $this->_productRepository->save($product);

        return $product;
    }

    protected function _updateProductStock(StockRecordInterface $stockRecord, ProductInterface $product)
    {
        try {
            $stockItem = $this->_stockRegistry->getStockItemBySku($stockRecord->getStockCode());

            if (($stockItem->getUseConfigBackorders() && $this->_scopeConfig->getValue(\Magento\CatalogInventory\Model\Configuration::XML_PATH_BACKORDERS))
                || (!$stockItem->getUseConfigBackorders() && $stockItem->getBackorders())) {
                $stockItem->setIsInStock(true);
            }

            if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/stock/multiple_locations')) {
                $qty = $stockRecord->getFreeStockQuantity();

                if (!(bool)$stockItem->getIsQtyDecimal()) {
                    $qty = round($qty, 0, PHP_ROUND_HALF_DOWN);
                }

                $stockItem->setQty($qty);
                $stockItem->setIsInStock($stockItem->getQty() > 0);

                if ($stockRecord->getNonSaleableOnWeb()) {
                    $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
                } else {
                    $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
                }
            }

            $this->_stockRegistry->updateStockItemBySku($stockRecord->getStockCode(), $stockItem);
            $product->setQuantityAndStockStatus(['qty' => $qty, 'is_in_stock' => $stockItem->getQty() > 0]);

        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $this->_logger->addError($exception);
        }
    }

}