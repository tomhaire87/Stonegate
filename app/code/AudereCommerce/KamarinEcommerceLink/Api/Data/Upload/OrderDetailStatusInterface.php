<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus;

interface OrderDetailStatusInterface
{
    const ENTITY_TYPE = 'order_detail_status';

    /**
      * @return OrderDetailStatus
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getOrderDetailsStatusesId();

	/**
	 * @return string
	 */
	public function getAccountsOrderNumber();

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
	public function getOrderedQuantity();

	/**
	 * @return float
	 */
	public function getDeliveredQuantity();

	/**
	 * @return string
	 */
	public function getOrderLineStatus();

	/**
	 * @return string
	 */
	public function getCustomText1();

	/**
	 * @return string
	 */
	public function getCustomText2();

	/**
	 * @return string
	 */
	public function getCustomText3();

	/**
	 * @return string
	 */
	public function getCustomDate1();

	/**
	 * @return string
	 */
	public function getCustomDate2();

	/**
	 * @return string
	 */
	public function getCustomDate3();

	/**
	 * @return float
	 */
	public function getOriginalWebOrderLineId();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
