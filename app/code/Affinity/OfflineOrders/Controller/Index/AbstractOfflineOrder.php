<?php

namespace Affinity\OfflineOrders\Controller\Index;

abstract class AbstractOfflineOrder extends \Magento\Customer\Controller\AbstractAccount
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
	 * @var \Affinity\OfflineOrders\Model\Order|null
	 */
	protected $_order	= null;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Affinity\OfflineOrders\Model\OrderFactory $orderFactory
	)
	{
		$this->_orderFactory	= $orderFactory;
		$this->_customerSession	= $customerSession;
		parent::__construct($context);
	}

	/**
	 * Get an order from request
	 *
	 * @return \Affinity\OfflineOrders\Model\Order
	 */
	protected function _getOrder()
	{
		if(is_null($this->_order)) {
			$orderId		= $this->getRequest()->getParam('order_id');
			$this->_order	= $this->_orderFactory->create()->load($orderId);
		}
		return $this->_order;
	}

	/**
	 * Check if the current logged in customer can view an order
	 *
	 * @return bool
	 */
	protected function _canViewOrder()
	{
		return $this->_getOrder()->getGroupId() === $this->_customerSession->getCustomerGroupId();
	}
}