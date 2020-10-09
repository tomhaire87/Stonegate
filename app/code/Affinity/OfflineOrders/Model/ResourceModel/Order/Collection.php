<?php

namespace Affinity\OfflineOrders\Model\ResourceModel\Order;

use Affinity\OfflineOrders\Model\Order as OrderModel;
use Affinity\OfflineOrders\Model\ResourceModel\Order as OrderResource;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

	/**
	 * {@inheritDoc}
	 */
	protected $_idFieldName	= 'entity_id';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventPrefix	= 'affinity_offline_order_collection';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventObject	= 'order_collection';

	protected function _construct()
	{
		$this->_init(OrderModel::class, OrderResource::class);
	}
}