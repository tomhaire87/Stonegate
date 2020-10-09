<?php

namespace Affinity\OfflineOrders\Model\ResourceModel\OrderAddress;

use Affinity\OfflineOrders\Model\OrderAddress as OrderAddressModel;
use Affinity\OfflineOrders\Model\ResourceModel\OrderAddress as OrderAddressResource;

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
	protected $_eventPrefix	= 'affinity_offline_order_address_collection';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventObject	= 'order_address_collection';

	protected function _construct()
	{
		$this->_init(OrderAddressModel::class, OrderAddressResource::class);
	}
}
