<?php

namespace Affinity\OfflineOrders\Model;

use NumberFormatter;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

use \Affinity\OfflineOrders\Model\ResourceModel\Order as OrderResource;

class Order extends AbstractModel implements IdentityInterface
{

	const CACHE_TAG	= 'affinity_offline_order';

	/**
	 * @var int
	 */
	const SALES_ORDER_ID_PAD_LENGTH	= 10;

	/**
	 * @var int
	 */
	const SALES_ORDER_ID_PAD_CHAR	= 0;

	/**
	 * @var int
	 */
	const CUSTOMER_ORDER_ID_PAD_LENGTH	= 9;

	/**
	 * @var int
	 */
	const CUSTOMER_ORDER_ID_PAD_CHAR	= 0;

	/**
	 * {@inheritDoc}
	 */
	protected $_cacheTag	= 'affinity_offline_order';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventPrefix	= 'affinity_offline_order';

	/**
	 * @var \Magento\Framework\Locale\Resolver
	 */
	protected $_resolver;

	/**
	 * @var \Magento\Framework\UrlInterface
	 */
	protected $_urlInterface;

	/**
	 * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
	 */
	protected $_timezoneInterface;

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\Locale\Resolver $resolver,
		\Magento\Framework\UrlInterface $urlInterface,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
		array $data = []
	)
	{
		$this->_resolver			= $resolver;
		$this->_urlInterface		= $urlInterface;
		$this->_timezoneInterface	= $timezoneInterface;
		parent::__construct(
			$context,
			$registry,
			$resource,
			$resourceCollection,
			$data
		);
	}

	/**
	 * Initialize resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init(OrderResource::class);
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

	/**
	 * Get order items for the current order
	 *
	 * @return \Affinity\OfflineOrders\Model\ResourceModel\OrderItem\Collection
	 */
	public function getOrderItems()
	{
		return $this->getResource()->getOrderItems($this);
	}

	/**
	 * @return \Affinity\OfflineOrders\Model\OrderAddress
	 */
	public function getInvoiceAddress()
	{
		return $this->_getAddress('invoice');
	}

	/**
	 * @return \Affinity\OfflineOrders\Model\OrderAddress
	 */
	public function getShippingAddress()
	{
		return $this->_getAddress('shipping');
	}

	/**
	 * @param  string  $type
	 * @return \Affinity\OfflineOrders\Model\OrderAddress
	 */
	public function _getAddress(string $type = 'invoice')
	{
		return $this->getResource()->getAddress($this, $type);
	}

	/**
	 * Get a padded `sales_order_number`
	 *
	 * @return string
	 */
	public function getSalesOrderNumber()
	{
		return str_pad(
			parent::getSalesOrderNumber(),
			self::SALES_ORDER_ID_PAD_LENGTH,
			self::SALES_ORDER_ID_PAD_CHAR,
			STR_PAD_LEFT
		);
	}

	/**
	 * Get a padded `customer_order_number`
	 *
	 * @return string
	 */
	public function getCustomerOrderNumber()
	{
		$number	= parent::getCustomerOrderNumber();
		if(!$number) return '-';

		return str_pad(
			$number,
			self::CUSTOMER_ORDER_ID_PAD_LENGTH,
			self::CUSTOMER_ORDER_ID_PAD_CHAR,
			STR_PAD_LEFT
		);
	}

	/**
	 * Get formatted `payment_amount`
	 *
	 * @return string
	 */
	public function getPaymentAmount()
	{
		$formatter	= new NumberFormatter($this->_resolver->getLocale(), NumberFormatter::CURRENCY);
		return $formatter->formatCurrency(
			parent::getPaymentAmount(),
			parent::getCurrency()
		);
	}

	/**
	 * Get formatted `sales_order_date`
	 *
	 * @return string
	 */
	public function getSalesOrderDate()
	{
		return $this->_timezoneInterface->formatDate(
			parent::getSalesOrderDate(),
			\IntlDateFormatter::MEDIUM
		);
	}

	/**
	 * Get PDF Download URL
	 * @return string
	 */
	public function getDownloadUrl()
	{
		return $this->_urlInterface->getUrl('offlineorders/index/download', [
			'order_id'	=> $this->getId()
		]);
	}

	/**
	 * Get View Order URL
	 * @return string
	 */
	public function getViewUrl()
	{
		return $this->_urlInterface->getUrl('offlineorders/index/view', [
			'order_id'	=> $this->getId()
		]);
	}

}