<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer;

interface CustomerInterface
{
    const ENTITY_TYPE = 'customer';

    /**
      * @return Customer
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getCustomerId();

	/**
	 * @return string
	 */
	public function getAccountCode();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getAddress1();

	/**
	 * @return string
	 */
	public function getAddress2();

	/**
	 * @return string
	 */
	public function getAddress3();

	/**
	 * @return string
	 */
	public function getAddress4();

	/**
	 * @return string
	 */
	public function getAddress5();

	/**
	 * @return string
	 */
	public function getPostcode();

	/**
	 * @return string
	 */
	public function getTelephoneNumber();

	/**
	 * @return string
	 */
	public function getFaxNumber();

	/**
	 * @return string
	 */
	public function getEmailAddress();

	/**
	 * @return string
	 */
	public function getPassword();

	/**
	 * @return string
	 */
	public function getPriceListCode();

	/**
	 * @return boolean
	 */
	public function getOnStop();

	/**
	 * @return string
	 */
	public function getVatCode();

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
	 * @return string
	 */
	public function getPriceBand();

	/**
	 * @return float
	 */
	public function getCreditLimit();

	/**
	 * @return float
	 */
	public function getAccountBalance();

	/**
	 * @return float
	 */
	public function getOrderBalance();

	/**
	 * @return string
	 */
	public function getCustomerType();

	/**
	 * @return string
	 */
	public function getDiscountCode();

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
	public function getCustomText4();

	/**
	 * @return string
	 */
	public function getCustomText5();

	/**
	 * @return string
	 */
	public function getCurrencyCode();

	/**
	 * @return string
	 */
	public function getCountryCode();

	/**
	 * @return string
	 */
	public function getInvoiceAccount();

	/**
	 * @return string
	 */
	public function getVatRegNumber();

	/**
	 * @return string
	 */
	public function getMobileNumber();

	/**
	 * @return float
	 */
	public function getDiscountPercentage();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
