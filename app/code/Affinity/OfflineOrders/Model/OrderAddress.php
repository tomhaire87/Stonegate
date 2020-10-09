<?php

namespace Affinity\OfflineOrders\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

use \Affinity\OfflineOrders\Model\ResourceModel\OrderAddress as OrderAddressResource;

class OrderAddress extends AbstractModel implements IdentityInterface
{

	const CACHE_TAG	= 'affinity_offline_order_address';

	/**
	 * {@inheritDoc}
	 */
	protected $_cacheTag	= 'affinity_offline_order_address';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventPrefix	= 'affinity_offline_order_address';

	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(OrderAddressResource::class);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	/**
	 * Get Default Values
	 *
	 * @return array
	 */
	public function getDefaultValues()
	{
		return [];
	}

}