<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Download;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader;

interface OrderHeaderInterface
{
    const ENTITY_TYPE = 'order_header';

    /**
      * @return OrderHeader
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getOrderHeaderId();

	/**
	 * @return string
	 */
	public function getOrderNumber();

	/**
	 * @return string
	 */
	public function getOrderDate();

	/**
	 * @return string
	 */
	public function getInvoiceName();

	/**
	 * @return string
	 */
	public function getInvoiceAddress1();

	/**
	 * @return string
	 */
	public function getInvoiceAddress2();

	/**
	 * @return string
	 */
	public function getInvoiceAddress3();

	/**
	 * @return string
	 */
	public function getInvoiceAddress4();

	/**
	 * @return string
	 */
	public function getInvoiceAddress5();

	/**
	 * @return string
	 */
	public function getInvoicePostcode();

	/**
	 * @return string
	 */
	public function getDeliveryName();

	/**
	 * @return string
	 */
	public function getDeliveryAddress1();

	/**
	 * @return string
	 */
	public function getDeliveryAddress2();

	/**
	 * @return string
	 */
	public function getDeliveryAddress3();

	/**
	 * @return string
	 */
	public function getDeliveryAddress4();

	/**
	 * @return string
	 */
	public function getDeliveryAddress5();

	/**
	 * @return string
	 */
	public function getDeliveryPostcode();

	/**
	 * @return string
	 */
	public function getDeliveryTelephoneNumber();

	/**
	 * @return string
	 */
	public function getDeliveryFaxNumber();

	/**
	 * @return string
	 */
	public function getEmailAddress();

	/**
	 * @return string
	 */
	public function getSalesLedgerAccountCode();

	/**
	 * @return string
	 */
	public function getComments();

	/**
	 * @return string
	 */
	public function getCustomerReferenceNumber();

	/**
	 * @return string
	 */
	public function getShippingMethod();

	/**
	 * @return boolean
	 */
	public function getPaymentWithOrder();

	/**
	 * @return string
	 */
	public function getPaymentMethod();

	/**
	 * @return string
	 */
	public function getLocationCode();

	/**
	 * @return string
	 */
	public function getCurrencyCode();

	/**
	 * @return float
	 */
	public function getOrderGrossTotal();

	/**
	 * @return string
	 */
	public function getUserField1();

	/**
	 * @return string
	 */
	public function getUserField2();

	/**
	 * @return string
	 */
	public function getUserField3();

	/**
	 * @return string
	 */
	public function getUserField4();

	/**
	 * @return string
	 */
	public function getUserField5();

	/**
	 * @return string
	 */
	public function getUserField6();

	/**
	 * @return string
	 */
	public function getUserField7();

	/**
	 * @return string
	 */
	public function getUserField8();

	/**
	 * @return string
	 */
	public function getUserField9();

	/**
	 * @return string
	 */
	public function getUserField10();

	/**
	 * @return float
	 */
	public function getExchangeRate();

	/**
	 * @return string
	 */
	public function getPaymentCode1();

	/**
	 * @return float
	 */
	public function getPaymentValue1();

	/**
	 * @return string
	 */
	public function getPaymentCode2();

	/**
	 * @return float
	 */
	public function getPaymentValue2();

	/**
	 * @return string
	 */
	public function getPaymentCode3();

	/**
	 * @return float
	 */
	public function getPaymentValue3();

	/**
	 * @return string
	 */
	public function getPaymentCode4();

	/**
	 * @return float
	 */
	public function getPaymentValue4();

	/**
	 * @return string
	 */
	public function getPaymentCode5();

	/**
	 * @return float
	 */
	public function getPaymentValue5();

	/**
	 * @return float
	 */
	public function getDiscountPercentage();

	/**
	 * @return float
	 */
	public function getTagNumber();

	/**
	 * @return boolean
	 */
	public function getRecordDownloaded();
}
