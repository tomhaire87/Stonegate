<?php

namespace Affinity\OfflineOrders\Model;

use NumberFormatter;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;

use \Affinity\OfflineOrders\Model\ResourceModel\OrderItem as OrderItemResource;

class OrderItem extends AbstractModel implements IdentityInterface
{

	const CACHE_TAG	= 'affinity_offline_order_item';

	/**
	 * {@inheritDoc}
	 */
	protected $_cacheTag	= 'affinity_offline_order_item';

	/**
	 * {@inheritDoc}
	 */
	protected $_eventPrefix	= 'affinity_offline_order_item';

	/**
	 * {@inheritDoc}
	 */
	public function __construct(
		\Magento\Framework\Locale\Resolver $resolver,
		\Magento\Framework\Model\Context $context,
		\Magento\Framework\Registry $registry,
		\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
		array $data = []
	) {
		$this->_resolver	= $resolver;
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
		$this->_init(OrderItemResource::class);
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
	 * Get formatted `unit_price`
	 *
	 * @param string $currency
	 */
	public function getUnitPrice(string $currency = 'GBP')
	{
		return $this->_formatPrice(parent::getUnitPrice(), $currency);
	}

	/**
	 * Get formatted `total_net`
	 *
	 * @param string $currency
	 */
	public function getTotalNet(string $currency = 'GBP')
	{
		return $this->_formatPrice(parent::getTotalNet(), $currency);
	}

	/**
	 * Get formatted `total_tax`
	 *
	 * @param string $currency
	 */
	public function getTotalTax(string $currency = 'GBP')
	{
		return $this->_formatPrice(parent::getTotalTax(), $currency);
	}

	/**
	 * Format Price
	 *
	 * @param float|int $amount
	 * @param string    $currency
	 */
	protected function _formatPrice($amount, string $currency = 'GBP')
	{
		$formatter	= new NumberFormatter($this->_resolver->getLocale(), NumberFormatter::CURRENCY);
		return $formatter->formatCurrency(
			$amount,
			$currency
		);
	}

}