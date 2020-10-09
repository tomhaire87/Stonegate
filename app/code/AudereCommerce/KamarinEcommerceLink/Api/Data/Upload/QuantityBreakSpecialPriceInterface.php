<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice;

interface QuantityBreakSpecialPriceInterface
{
    const ENTITY_TYPE = 'quantity_break_special_price';

    /**
      * @return QuantityBreakSpecialPrice
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getQtyBreakPriceId();

	/**
	 * @return string
	 */
	public function getPriceListCode();

	/**
	 * @return string
	 */
	public function getStockCode();

	/**
	 * @return float
	 */
	public function getFromQty();

	/**
	 * @return float
	 */
	public function getToQty();

	/**
	 * @return float
	 */
	public function getSpecialPrice();

	/**
	 * @return int
	 */
	public function getPriority();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
