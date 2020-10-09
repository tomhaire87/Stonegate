<?php

namespace Affinity\OfflineOrders\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderAddress extends AbstractDb
{

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	) {
		parent::__construct($context);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function _construct()
	{
		$this->_init('offline_order_address', 'entity_id');
	}
}