<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate;

interface VatRateInterface
{
    const ENTITY_TYPE = 'vat_rate';

    /**
      * @return VatRate
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getVatRateId();

	/**
	 * @return string
	 */
	public function getCode();

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return float
	 */
	public function getRate();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
