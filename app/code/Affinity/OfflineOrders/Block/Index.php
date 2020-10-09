<?php

namespace Affinity\OfflineOrders\Block;

use Magento\Framework\View\Element\Template;

class Index extends Template
{

	/**
	 * @var \Affinity\OfflineOrders\Model\ResourceModel\Order\CollectionFactory
	 */
	protected $_orderCollectionFactory;

	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $_customerSession;

	/**
	 * @var \Affinity\OfflineOrders\Model\ResourceModel\Order\Collection
	 */
	protected $_orders;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Affinity\OfflineOrders\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
		\Magento\Customer\Model\Session $customerSession,
		array $data = []
	)
	{
		$this->_orderCollectionFactory	= $orderCollectionFactory;
		$this->_customerSession			= $customerSession;
		parent::__construct($context, $data);
	}

	/**
	 * Get collection of offline orders for
	 * current logged in Customer's Group
	 *
	 * @return \Affinity\OfflineOrders\Model\ResourceModel\Order\Collection
	 */
	public function getOfflineOrders()
	{
		if(!$this->_orders) {
			$this->_orders	= $this->_orderCollectionFactory
								   ->create()
								   ->addFieldToSelect('*')
								   ->addFieldToFilter('group_id', $this->_customerSession->getCustomerGroupId());
		}
		return $this->_orders;
	}
}