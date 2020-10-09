<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Download;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer;

interface NewCustomerInterface
{
    const ENTITY_TYPE = 'new_customer';

    /**
      * @return NewCustomer
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
	public function getMobileNumber();

	/**
	 * @return string
	 */
	public function getEmailAddress();

	/**
	 * @return string
	 */
	public function getCostCentre();

	/**
	 * @return string
	 */
	public function getDepartment();

	/**
	 * @return string
	 */
	public function getPassword();

	/**
	 * @return string
	 */
	public function getCurrencyCode();

	/**
	 * @return string
	 */
	public function getVatRegNumber();

	/**
	 * @return string
	 */
	public function getContactName();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param string $address1
     */
    public function setAddress1($address1);

    /**
     * @param string $address2
     */
    public function setAddress2($address2);

    /**
     * @param string $address3
     */
    public function setAddress3($address3);

    /**
     * @param string $address4
     */
    public function setAddress4($address4);

    /**
     * @param string $address5
     */
    public function setAddress5($address5);

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode);

    /**
     * @param string $telephoneNumber
     */
    public function setTelephoneNumber($telephoneNumber);

    /**
     * @param string $faxNumber
     */
    public function setFaxNumber($faxNumber);

    /**
     * @param string $mobileNumber
     */
    public function setMobileNumber($mobileNumber);

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress);

    /**
     * @param string $costCentre
     */
    public function setCostCentre($costCentre);

    /**
     * @param string $department
     */
    public function setDepartment($department);

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @param string $currencyCode
     */

    public function setCurrencyCode($currencyCode);

    /**
     * @param string $vatRegNumber
     */
    public function setVatRegNumber($vatRegNumber);

    /**
     * @param string $contactName
     */
    public function setContactName($contactName);

    /**
     * @param boolean $recordUpdated
     */
    public function setRecordUpdated($recordUpdated);
}
