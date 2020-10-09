<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Download;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail;

interface OrderDetailInterface
{
    const ENTITY_TYPE = 'order_detail';

    /**
      * @return OrderDetail
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getOrderDetailsId();

	/**
	 * @return int
	 */
	public function getOrderHeaderId();

	/**
	 * @return string
	 */
	public function getStockCode();

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return float
	 */
	public function getUnitNettPrice();

	/**
	 * @return float
	 */
	public function getQuantitySold();

	/**
	 * @return float
	 */
	public function getLineNettValue();

	/**
	 * @return float
	 */
	public function getLineVatValue();

	/**
	 * @return string
	 */
	public function getVatCode();

	/**
	 * @return float
	 */
	public function getVatRate();

	/**
	 * @return float
	 */
	public function getOriginalWebOrderLineId();

	/**
	 * @return string
	 */
	public function getLocationCode();
}
