<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice;

interface CustomerSpecialPriceInterface
{
    const ENTITY_TYPE = 'customer_special_price';

    /**
      * @return CustomerSpecialPrice
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getSpecialPriceId();

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
	public function getSpecialPrice();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
