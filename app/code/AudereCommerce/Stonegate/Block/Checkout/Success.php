<?php

namespace AudereCommerce\Stonegate\Block\Checkout;

class Success extends \Magento\Framework\View\Element\Template
{
    protected $_salesFactory;

    protected $_checkoutSession;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\Order $salesFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        $this->_salesFactory = $salesFactory;
        $this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current order
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        $order = $this->_checkoutSession->getLastRealOrder();
        return $order;
    }
}