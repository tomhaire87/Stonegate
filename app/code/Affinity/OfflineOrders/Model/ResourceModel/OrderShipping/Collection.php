<?php

namespace Affinity\OfflineOrders\Model\ResourceModel\OrderShipping;

use Affinity\OfflineOrders\Model\OrderShipping as OrderShippingModel;
use Affinity\OfflineOrders\Model\ResourceModel\OrderShipping as OrderShippingResource;

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
	protected $_eventPrefix	= 'affinity_offline_order_shipping_collection';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventObject	= 'order_shipping_collection';

	protected function _construct()
	{
		$this->_init(OrderShippingModel::class, OrderShippingResource::class);
	}
}
