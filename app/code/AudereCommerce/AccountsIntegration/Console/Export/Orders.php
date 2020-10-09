<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Export;

use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\AccountsIntegration\Helper\Factor as FactorHelper;
use AudereCommerce\KamarinEcommerceLink\Api\Download\OrderDetailRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Download\OrderHeaderRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockRecordRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\VatRateRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Model\Download\OrderDetailFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\State;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Logger\Monolog;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Orders extends AbstractConsole
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
     * @var AccountRepositoryInterface
     */
    protected $_accountRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var GroupRepositoryInterface
     */
    protected $_groupRepository;

    /**
     * @var StockRecordRepositoryInterface
     */
    protected $_stockRecordRepository;

    /**
     * @var OrderHeaderRepositoryInterface
     */
    protected $_orderHeaderRepository;

    /**
     * @var OrderDetailRepositoryInterface
     */
    protected $_orderDetailRepository;

    /**
     * @var OrderDetailFactory
     */
    protected $_orderDetailFactory;

    /**
     * @var VatRateRepositoryInterface
     */
    protected $_vatRateRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * @var Monolog
     */
    protected $_logger;

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        FactorHelper $factorHelper,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        AccountRepositoryInterface $accountRepository,
        OrderRepositoryInterface $orderRepository,
        GroupRepositoryInterface $groupRepository,
        StockRecordRepositoryInterface $stockRecordRepository,
        OrderHeaderRepositoryInterface $orderHeaderRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        OrderDetailFactory $orderDetailFactory,
        VatRateRepositoryInterface $vatRateRepository,
        ProductRepositoryInterface $productRepository,
        ResourceConnection $resourceConnection,
        Monolog $logger
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_factorHelper = $factorHelper;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_accountRepository = $accountRepository;
        $this->_orderRepository = $orderRepository;
        $this->_groupRepository = $groupRepository;
        $this->_stockRecordRepository = $stockRecordRepository;
        $this->_orderHeaderRepository = $orderHeaderRepository;
        $this->_orderDetailRepository = $orderDetailRepository;
        $this->_orderDetailFactory = $orderDetailFactory;
        $this->_vatRateRepository = $vatRateRepository;
        $this->_productRepository = $productRepository;
        $this->_resourceConnection = $resourceConnection;
        $this->_logger = $logger;

        parent::__construct('auderecommerce:accountsintegration:export:orders');
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

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/export')) {
            $this->log("Order exporting is not enabled");
        } else {
            $orderStatuses = explode(',', $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/export_statuses'));

            $searchCriteriaBuilder = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('status', $orderStatuses, 'in');

            $orderExportDate = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/export_date_start');

            if ($orderExportDate && trim($orderExportDate)) {
                $fromDate = new \DateTime($orderExportDate);
                $fromDateFormatted = $fromDate->format('Y-m-d H:i:s');
                $searchCriteriaBuilder->addFilter('created_at', $fromDateFormatted, 'from');
            }

            $connection = $this->_resourceConnection->getConnection('kamarin_ecommerce_link');

            $select = $connection
                ->select()
                ->from($connection->getTableName('order_headers'), array('order_number'))
                ->where('record_downloaded = ?', 1);

            $exportedOrderIds = $connection->fetchCol($select);

            if (!empty($exportedOrderIds)) {
                $searchCriteriaBuilder->addFilter('increment_id', $exportedOrderIds, 'nin');
            }

            $searchResults = $this->_orderRepository->getList($searchCriteriaBuilder->create());
            $orders = $searchResults->getItems();

            $totalCount = count($orders);
            $currentItem = 0;

            if ($totalCount <= 0) {
                $this->log("No orders to export");
            } else {
                $this->log("Exporting {$totalCount} orders");

                $locationCode = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/location');
                $defaultAccountCode = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/default_account');

                $searchCriteria = $this->_searchCriteriaBuilderFactory
                    ->create()
                    ->create();

                $searchResults = $this->_vatRateRepository->getList($searchCriteria);

                $vatRates = array();

                foreach ($searchResults->getItems() as $vatRate) {
                    $vatRates[$vatRate->getVatRateId()] = $vatRate;
                }

                foreach ($orders as $order) {
                    $currentItem++;
                    $orderId = $order->getEntityId();
                    $this->log("Order {$currentItem}/{$totalCount} (ID: {$orderId})");

                    try {
                        $orderHeader = $this->_orderHeaderRepository->getByOrderNumber($order->getIncrementId());

                        if ($orderHeader->getId()) {
                            continue;
                        }

                        $shippingAddress = $order->getShippingAddress();
                        $billingAddress = $order->getBillingAddress();
                        $payment = $order->getPayment();
                        $method = $payment->getMethodInstance();

                        if (!$billingAddress) {
                            throw new \Exception('Missing shipping and billing address: ' . $order->getCustomerEmail());
                        }

                        if (!$shippingAddress) {
                            $shippingAddress = $billingAddress;
                        }

                        if ($customerId = $order->getCustomerGroupId()) {
                            $customerGroup = $this->_groupRepository->getById($order->getCustomerGroupId());
                            $customerGroupCode = $customerGroup->getCode();

                            try {
                                $account = $this->_accountRepository->getByCode($customerGroupCode);
                                $accountCode = $account->getCode();
                            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {

                            }
                        }

                        $accountCode = isset($accountCode) ? $accountCode : $defaultAccountCode;
                        $orderHeader->setOrderNumber($order->getIncrementId());
                        $orderHeader->setOrderDate($order->getCreatedAt());
                        $orderHeader->setDeliveryTelephoneNumber($shippingAddress->getTelephone());
                        $orderHeader->setEmailAddress($order->getCustomerEmail());
                        $orderHeader->setSalesLedgerAccountCode($accountCode);
                        $orderHeader->setComments($order->getCustomerNote());
                        $orderHeader->setCustomerReferenceNumber($payment->getPoNumber());
                        $orderHeader->setShippingMethod($order->getShippingDescription());
                        $orderHeader->setPaymentWithOrder($method->isOffline() ? 0 : 1);
                        $orderHeader->setPaymentMethod($method->getCode());
                        $orderHeader->setLocationCode($locationCode);
                        $orderHeader->setCurrencyCode($order->getOrderCurrencyCode());
                        $orderHeader->setOrderGrossTotal($order->getGrandTotal());
                        $orderHeader->setInvoiceName($billingAddress->getFirstname() . ' ' . $billingAddress->getLastname());
                        $billingStreet = $billingAddress->getStreet();

                        if ($company = $billingAddress->getCompany()) {
                            $orderHeader->setData('invoice_address_1', $company);
                            $orderHeader->setData('invoice_address_2', isset($billingStreet[0]) ? $billingStreet[0] : null);
                            $orderHeader->setData('invoice_address_3', isset($billingStreet[1]) ? $billingStreet[1] : null);
                        } else {
                            $orderHeader->setData('invoice_address_1', isset($billingStreet[0]) ? $billingStreet[0] : null);
                            $orderHeader->setData('invoice_address_2', isset($billingStreet[1]) ? $billingStreet[1] : null);
                        }

                        $orderHeader->setData('invoice_address_4', $billingAddress->getRegion());
                        $orderHeader->setData('invoice_address_5', $billingAddress->getCountryId());
                        $orderHeader->setData('invoice_postcode', $billingAddress->getPostcode());

                        $orderHeader->setDeliveryName($shippingAddress->getFirstname() . ' ' . $shippingAddress->getLastname());
                        $shippingStreet = $shippingAddress->getStreet();

                        if ($company = $shippingAddress->getCompany()) {
                            $orderHeader->setData('delivery_address_1', $company);
                            $orderHeader->setData('delivery_address_2', isset($shippingStreet[0]) ? $shippingStreet[0] : null);
                            $orderHeader->setData('delivery_address_3', isset($shippingStreet[1]) ? $shippingStreet[1] : null);
                        } else {
                            $orderHeader->setData('delivery_address_1', isset($shippingStreet[0]) ? $shippingStreet[0] : null);
                            $orderHeader->setData('delivery_address_2', isset($shippingStreet[1]) ? $shippingStreet[1] : null);
                        }

                        $orderHeader->setData('delivery_address_4', $shippingAddress->getRegion());
                        $orderHeader->setData('delivery_address_5', $shippingAddress->getCountryId());
                        $orderHeader->setData('delivery_postcode', $shippingAddress->getPostcode());

                        $this->_orderHeaderRepository->save($orderHeader);

                        if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/export_shipping')) {
                            $vatCodeId = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/shipping_vat_code');
                            $vatRate = $vatRates[$vatCodeId];

                            $orderDetail = $this->_orderDetailFactory->create();
                            $orderDetail->setOrderHeaderId($orderHeader->getOrderHeaderId());
                            $orderDetail->setStockCode($this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/shipping_stock_code'));
                            $orderDetail->setDescription($order->getShippingDescription());
                            $orderDetail->setUnitNettPrice($order->getShippingAmount());
                            $orderDetail->setLineNettValue($order->getShippingAmount());
                            $orderDetail->setLineVatValue($order->getShippingTaxAmount());
                            $orderDetail->setOriginalWebOrderLineId(0);
                            $orderDetail->setLocationCode($locationCode);
                            $orderDetail->setQuantitySold(1);
                            $orderDetail->setVatCode($vatRate->getVatRateId());
                            $orderDetail->setVatRate($vatRate->getRate());

                            $this->_orderDetailRepository->save($orderDetail);
                        }

                        foreach ($order->getItems() as $orderItem) {
                            if (!$orderItem->getParentItemId()) {
                                if ($orderItem->getProductType() == \Magento\Bundle\Model\Product\Type::TYPE_CODE) {
                                    continue;
                                }

                                try {
                                    $stockRecord = $this->_stockRecordRepository->getByStockCode($orderItem->getSku());
                                    $vatCode = $stockRecord->getVatCode();
                                } catch (NoSuchEntityException $exception) {
                                    $vatCode = null;
                                }

                                $orderDetail = $this->_orderDetailRepository->getByItemId($orderItem->getItemId());
                                $orderDetail->setOrderHeaderId($orderHeader->getOrderHeaderId());
                                $orderDetail->setStockCode($orderItem->getSku());
                                $orderDetail->setDescription($orderItem->getName());
                                $orderDetail->setUnitNettPrice($orderItem->getPrice());
                                $orderDetail->setLineNettValue($orderItem->getRowTotal());
                                $orderDetail->setLineVatValue($orderItem->getTaxAmount());
                                $orderDetail->setVatCode($vatCode);
                                $orderDetail->setVatRate($orderItem->getTaxPercent());
                                $orderDetail->setOriginalWebOrderLineId($orderItem->getItemId());
                                $orderDetail->setLocationCode($locationCode);

                                if ($orderItem->getProductType() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
                                    $product = $this->_productRepository->get($orderItem->getSku());
                                    $orderDetail->setDescription($product->getName());
                                }

                                $quantity = $orderItem->getQtyOrdered();

                                if ($this->_factorHelper->isFactorEnabled()) {
                                    $factor = $this->_factorHelper->getProductFactor($orderItem->getProduct());
                                    $quantity = $this->_factorHelper->getExportQuantity($quantity, $factor);
                                    $orderDetail->setUnitNettPrice($orderDetail->getLineNettValue() / $quantity);
                                }

                                $orderDetail->setQuantitySold($quantity);

                                $this->_orderDetailRepository->save($orderDetail);
                            }
                        }
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