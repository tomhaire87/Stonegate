<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import;

use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockQuantitiesRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities\CollectionFactory as StockQuantitiesCollectionFactory;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Logger\Monolog;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MultipleStock extends AbstractConsole
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
     * @var StockQuantitiesCollectionFactory
     */
    protected $_stockQuantitiesCollectionFactory;

    /**
     * @var StockQuantitiesRepositoryInterface
     */
    protected $_stockQuantitiesRepository;

    /**
     * @var StockRegistryInterface
     */
    protected $_stockRegistry;

    /**
     * @var Monolog
     */
    protected $_logger;

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        StockQuantitiesCollectionFactory $stockQuantitiesCollectionFactory,
        StockQuantitiesRepositoryInterface $stockQuantitiesRepository,
        StockRegistryInterface $stockRegistry,
        Monolog $logger
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_stockQuantitiesCollectionFactory = $stockQuantitiesCollectionFactory;
        $this->_stockQuantitiesRepository = $stockQuantitiesRepository;
        $this->_stockRegistry = $stockRegistry;
        $this->_logger = $logger;

        parent::__construct('auderecommerce:accountsintegration:import:multiple-stock');
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

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/stock/import')
            || !$this->_scopeConfig->getValue('auderecommerce_accountsintegration/stock/multiple_locations')) {
            $this->log("Multiple stock importing is not enabled");
        } else {
            $globalBackorders = $this->_scopeConfig->getValue(\Magento\CatalogInventory\Model\Configuration::XML_PATH_BACKORDERS);

            $locations = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/stock/locations');
            $locations = explode(',', $locations);

            $stockCodes = $this->_stockQuantitiesCollectionFactory
                ->create()
                ->addFieldToSelect('stock_code')
                ->addFieldToFilter('record_updated', '1')
                ->addFieldToFilter('location_code', array('in' => $locations));

            $stockCodes->getSelect()->group('stock_code');

            $stockCodesSize = $stockCodes->getSize();
            $currentRecordCount = 0;

            if ($stockCodesSize <= 0) {
                $this->log("No multiple stock to import");
            } else {
                $this->log("Importing {$stockCodesSize} multiple stock");

                foreach ($stockCodes as $stockCode) {
                    try {
                        $currentRecordCount++;
                        $stockCode = $stockCode->getStockCode();
                        $this->log("Multiple stock {$currentRecordCount}/{$stockCodesSize} (SKU: {$stockCode})");

                        $stockItem = $this->_stockRegistry->getStockItemBySku($stockCode);

                        $stockQuantities = $this->_stockQuantitiesCollectionFactory
                            ->create()
                            ->addFieldToFilter('stock_code', $stockCode)
                            ->addFieldToFilter('location_code', array('in' => $locations));

                        $totalStockQuantity = 0;

                        foreach ($stockQuantities as $stockQuantity) {
                            $totalStockQuantity += (float)$stockQuantity->getFreeStockQuantity();

                            if ($stockQuantity->getRecordUpdated()) {
                                $stockQuantity->setRecordUpdated(0);
                                $this->_stockQuantitiesRepository->save($stockQuantity);
                            }
                        }

                        if (!(bool)$stockItem->getIsQtyDecimal()) {
                            $totalStockQuantity = round($totalStockQuantity, 0, PHP_ROUND_HALF_DOWN);
                        }

                        $stockItem->setQty($totalStockQuantity);
                        $stockItem->setIsInStock($stockItem->getQty() > 0);

                        if (($stockItem->getUseConfigBackorders() && $globalBackorders) || (!$stockItem->getUseConfigBackorders() && $stockItem->getBackorders())) {
                            $stockItem->setIsInStock(true);
                        }

                        $this->_stockRegistry->updateStockItemBySku($stockCode, $stockItem);
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

}