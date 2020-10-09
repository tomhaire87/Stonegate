<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus;

interface OrderHeaderStatusInterface
{
    const ENTITY_TYPE = 'order_header_status';

    /**
      * @return OrderHeaderStatus
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getOrderHeadersStatusesId();

	/**
	 * @return string
	 */
	public function getAccountsOrderNumber();

	/**
	 * @return string
	 */
	public function getWebOrderNumber();

	/**
	 * @return string
	 */
	public function getOrderDate();

	/**
	 * @return string
	 */
	public function getLastDeliveryDate();

	/**
	 * @return string
	 */
	public function getLastDeliveryNumber();

	/**
	 * @return string
	 */
	public function getOrderStatus();

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
	 * @return boolean
	 */
	public function getRecordUpdated();
}
