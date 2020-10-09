<?php

namespace Affinity\OfflineOrders\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Order extends AbstractDb
{

	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $_customerSession;

	/**
	 * @var \Affinity\OfflineOrders\Model\ResourceModel\OrderItem\CollectionFactory
	 */
	protected $_orderItemCollectionFactory;

	/**
	 * @var \Affinity\OfflineOrders\Model\ResourceModel\orderAddressFactory
	 */
	protected $_orderAddressCollectionFactory;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Affinity\OfflineOrders\Model\ResourceModel\OrderItem\CollectionFactory $orderItemCollectionFactory,
		\Affinity\OfflineOrders\Model\ResourceModel\OrderAddress\CollectionFactory $orderAddressCollectionFactory
	)
	{
		$this->_customerSession					= $customerSession;
		$this->_orderItemCollectionFactory		= $orderItemCollectionFactory;
		$this->_orderAddressCollectionFactory	= $orderAddressCollectionFactory;
		parent::__construct($context);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function _construct()
	{
		$this->_init('offline_order', 'entity_id');
	}

	/**
	 * Get order items for a specified order
	 *
	 * @param  \Affinity\OfflineOrders\Model\Order  $order
	 *
	 * @return \Affinity\OfflineOrders\Model\ResourceModel\OrderItem\Collection
	 */
	public function getOrderItems(
		\Affinity\OfflineOrders\Model\Order $order
	)
	{
		return $this->_orderItemCollectionFactory
					->create()
					->addFieldToFilter('order_id', $order->getId());
	}

	/**
	 * Get order items for a specified order
	 *
	 * @param  \Affinity\OfflineOrders\Model\Order  $order
	 *
	 * @return \Affinity\OfflineOrders\Model\ResourceModel\OrderAddress
	 */
	public function getAddress(
		\Affinity\OfflineOrders\Model\Order $order,
		string $type = 'invoice'
	)
	{
		return $this->_orderAddressCollectionFactory
					->create()
					->addFieldToFilter('order_id', $order->getId())
					->addFieldToFilter('address_type', $type)
					->getFirstItem();
	}
}