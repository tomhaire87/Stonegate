<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import;

use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\AccountsIntegration\Helper\Factor as FactorHelper;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\OrderDetailStatusRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\OrderHeaderStatusRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Logger\Monolog;
use Magento\Payment\Api\Data\PaymentMethodInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Sales\Api\Data\OrderPaymentInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\InvoiceOrderFactory;
use Magento\Sales\Model\ShipOrderFactory;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Shipments extends AbstractConsole
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
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var FactorHelper
     */
    protected $_factorHelper;

    /**
     * @var OrderHeaderStatusRepositoryInterface
     */
    protected $_orderHeaderStatusRepository;

    /**
     * @var OrderDetailStatusRepositoryInterface
     */
    protected $_orderDetailStatusRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var OrderItemRepositoryInterface
     */
    protected $_orderItemRepository;

    /**
     * @var ShipOrderFactory
     */
    protected $_shipOrderFactory;

    /**
     * @var InvoiceOrderFactory
     */
    protected $_invoiceOrderFactory;

    /**
     * @var Monolog
     */
    protected $_logger;

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        FactorHelper $factorHelper,
        OrderHeaderStatusRepositoryInterface $orderHeaderStatusRepository,
        OrderDetailStatusRepositoryInterface $orderDetailStatusRepository,
        OrderRepositoryInterface $orderRepository,
        OrderItemRepositoryInterface $orderItemRepository,
        ShipOrderFactory $shipOrderFactory,
        InvoiceOrderFactory $invoiceOrderFactory,
        Monolog $logger
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_factorHelper = $factorHelper;
        $this->_orderHeaderStatusRepository = $orderHeaderStatusRepository;
        $this->_orderDetailStatusRepository = $orderDetailStatusRepository;
        $this->_orderRepository = $orderRepository;
        $this->_orderItemRepository = $orderItemRepository;
        $this->_shipOrderFactory = $shipOrderFactory;
        $this->_invoiceOrderFactory = $invoiceOrderFactory;
        $this->_logger = $logger;

        parent::__construct('auderecommerce:accountsintegration:import:shipments');
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

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/shipment')) {
            $this->log("Shipment importing is not enabled");
        } else {
            $shipOrder = $this->_shipOrderFactory->create();
            $invoiceOrder = $this->_invoiceOrderFactory->create();

            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('record_updated', '1')
                ->create();

            $searchResults = $this->_orderDetailStatusRepository->getList($searchCriteria);

            $orders = array();

            foreach ($searchResults->getItems() as $orderDetailStatus) {
                $orders[$orderDetailStatus->getAccountsOrderNumber()][] = $orderDetailStatus;
            }

            $orderCount = count($orders);
            $currentRecordCount = 0;

            $quantityField = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/shipment_quantity');

            if ($orderCount <= 0) {
                $this->log("No shipments to import");
            } else {
                $this->log("Importing {$orderCount} shipments");

                foreach ($orders as $accountsOrderId => $orderDetailsStatuses) {
                    try {
                        $currentRecordCount++;
                        $this->log("Shipment {$currentRecordCount}/{$orderCount} (Order ID: {$accountsOrderId})");

                        $searchCriteria = $this->_searchCriteriaBuilderFactory
                            ->create()
                            ->addFilter('accounts_order_number', $accountsOrderId)
                            ->create();

                        $searchResults = $this->_orderHeaderStatusRepository->getList($searchCriteria);
                        $searchItems = $searchResults->getItems();
                        $orderHeaderStatus = reset($searchItems);

                        if (empty($orderHeaderStatus)) {
                            continue;
                        }

                        $searchCriteria = $this->_searchCriteriaBuilderFactory
                            ->create()
                            ->addFilter('increment_id', $orderHeaderStatus->getWebOrderNumber())
                            ->create();

                        $searchResults = $this->_orderRepository->getList($searchCriteria);
                        $searchItems = $searchResults->getItems();
                        $order = reset($searchItems);

                        if (!$order) {
                            throw new \Exception('Unable to find order');
                        }

                        $orderItems = array();

                        foreach ($orderDetailsStatuses as $orderDetailsStatus) {
                            try {
                                if ($orderDetailsStatus->getOriginalWebOrderLineId() == '0') {
                                    foreach ($order->getItems() as $_orderItem) {
                                        $quantity = $_orderItem->getQtyOrdered();

                                        if ($this->_factorHelper->isFactorEnabled()) {
                                            $factor = $this->_factorHelper->getProductFactor($_orderItem->getProduct());
                                            $quantity = $this->_factorHelper->getExportQuantity($quantity, $factor);
                                        }

                                        if ($_orderItem->getSku() == $orderDetailsStatus->getStockCode() && $quantity == $orderDetailsStatus->getOrderedQuantity()) {
                                            $deliveredQuantity = $orderDetailsStatus[$quantityField];

                                            if ($this->_factorHelper->isFactorEnabled()) {
                                                $factor = $this->_factorHelper->getProductFactor($_orderItem->getProduct());
                                                $deliveredQuantity = $this->_factorHelper->getOriginalExportQuantity($deliveredQuantity, $factor);
                                            }

                                            $orderItem = new \Magento\Framework\DataObject;
                                            $orderItem->setOrderItemId($_orderItem->getId());
                                            $orderItem->setQty($deliveredQuantity);
                                            $orderItems[] = $orderItem;
                                            break;
                                        }
                                    }
                                } else {
                                    $deliveredQuantity = $orderDetailsStatus[$quantityField];

                                    if ($this->_factorHelper->isFactorEnabled()) {
                                        $_orderItem = $this->_orderItemRepository->get($orderDetailsStatus['original_web_order_line_id']);
                                        $factor = $this->_factorHelper->getProductFactor($_orderItem->getProduct());
                                        $deliveredQuantity = $this->_factorHelper->getOriginalExportQuantity($deliveredQuantity, $factor);
                                    }

                                    $orderItem = new \Magento\Framework\DataObject;
                                    $orderItem->setOrderItemId($orderDetailsStatus['original_web_order_line_id']);
                                    $orderItem->setQty($deliveredQuantity);
                                    $orderItems[] = $orderItem;
                                }

                                $orderDetailsStatus->setRecordUpdated(0);
                                $orderDetailsStatus->save();
                            } catch (\Exception $exception) {
                                $this->log($exception);
                                $this->_logger->addError($exception);
                            }
                        }

                        if (!empty($orderItems)) {
                            $shipOrder->execute($order->getId(), $orderItems, false);

                            if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/shipment_invoice')) {
                                if ($order->getInvoiceCollection()->count() == 0) {

                                    $payment = $order->getPayment();
                                    if ($payment instanceof OrderPaymentInterface) {

                                        $method = $payment->getMethodInstance();
                                        if ($method instanceof MethodInterface) {

                                            $offline = $method->isOffline();

                                            if ($offline) {
                                                $invoiceOrder->execute($order->getId(), false, $orderItems, false);
                                            }
                                        }
                                    }
                                }
                            }
                        }

                    } catch (\Magento\Sales\Exception\DocumentValidationException $exception) {

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