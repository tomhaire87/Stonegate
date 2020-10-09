<?php

namespace Affinity\OfflineOrders\Block;

class View extends \Magento\Framework\View\Element\Template
{
	/**
	 * @var \Affinity\OfflineOrders\Model\OrderFactory
	 */
	protected $_orderFactory;

	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $_customerSession;

	/**
	 * @var \Affinity\OfflineOrders\Model\Order
	 */
	protected $_order;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Affinity\OfflineOrders\Model\OrderFactory $orderFactory,
		array $data = []
	)
	{
		$this->_orderFactory	= $orderFactory;
		$this->_customerSession	= $customerSession;

		parent::__construct($context, $data);
	}

	public function getOrder()
	{
		if(!$this->_order) {
			$this->_order	= $this->_orderFactory->create()->load($this->getRequest()->getParam('order_id'));
		}
		return $this->_order;
	}
}