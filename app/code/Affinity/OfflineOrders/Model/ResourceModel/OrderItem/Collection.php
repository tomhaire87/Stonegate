<?php

namespace Affinity\OfflineOrders\Model\ResourceModel\OrderItem;

use Affinity\OfflineOrders\Model\OrderItem as OrderItemModel;
use Affinity\OfflineOrders\Model\ResourceModel\OrderItem as OrderItemResource;

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
	protected $_eventPrefix	= 'affinity_offline_order_item_collection';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventObject	= 'order_item_collection';

	protected function _construct()
	{
		$this->_init(OrderItemModel::class, OrderItemResource::class);
	}
}
