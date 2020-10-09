<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerInterface;
use Magento\Framework\Model\AbstractModel;

class NewCustomer extends AbstractModel implements NewCustomerInterface
{
    const CUSTOMER_ID = 'customer_id';
    const ACCOUNT_CODE = 'account_code';
    const NAME = 'name';
    const ADDRESS1 = 'address1';
    const ADDRESS2 = 'address2';
    const ADDRESS3 = 'address3';
    const ADDRESS4 = 'address4';
    const ADDRESS5 = 'address5';
    const POSTCODE = 'postcode';
    const TELEPHONE_NUMBER = 'telephone_number';
    const FAX_NUMBER = 'fax_number';
    const MOBILE_NUMBER = 'mobile_number';
    const EMAIL_ADDRESS = 'email_address';
    const COST_CENTRE = 'cost_centre';
    const DEPARTMENT = 'department';
    const PASSWORD = 'password';
    const CURRENCY_CODE = 'currency_code';
    const VAT_REG_NUMBER = 'vat_reg_number';
    const CONTACT_NAME = 'contact_name';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer');
    }

	/**
	 * @return int
	 */
	public function getCustomerId()
	{
	    return $this->getData(self::CUSTOMER_ID);
	}
	
    /**
     * @param int $customerId
     */
	public function setCustomerId($customerId)
	{
	    $this->setData(self::CUSTOMER_ID, (int)$customerId);
	}

	/**
	 * @return string
	 */
	public function getAccountCode()
	{
	    return $this->getData(self::ACCOUNT_CODE);
	}
	
    /**
     * @param string $accountCode
     */
	public function setAccountCode($accountCode)
	{
	    $this->setData(self::ACCOUNT_CODE, (string)$accountCode);
	}

	/**
	 * @return string
	 */
	public function getName()
	{
	    return $this->getData(self::NAME);
	}
	
    /**
     * @param string $name
     */
	public function setName($name)
	{
	    $this->setData(self::NAME, (string)$name);
	}

	/**
	 * @return string
	 */
	public function getAddress1()
	{
	    return $this->getData(self::ADDRESS1);
	}
	
    /**
     * @param string $address1
     */
	public function setAddress1($address1)
	{
	    $this->setData(self::ADDRESS1, (string)$address1);
	}

	/**
	 * @return string
	 */
	public function getAddress2()
	{
	    return $this->getData(self::ADDRESS2);
	}
	
    /**
     * @param string $address2
     */
	public function setAddress2($address2)
	{
	    $this->setData(self::ADDRESS2, (string)$address2);
	}

	/**
	 * @return string
	 */
	public function getAddress3()
	{
	    return $this->getData(self::ADDRESS3);
	}
	
    /**
     * @param string $address3
     */
	public function setAddress3($address3)
	{
	    $this->setData(self::ADDRESS3, (string)$address3);
	}

	/**
	 * @return string
	 */
	public function getAddress4()
	{
	    return $this->getData(self::ADDRESS4);
	}
	
    /**
     * @param string $address4
     */
	public function setAddress4($address4)
	{
	    $this->setData(self::ADDRESS4, (string)$address4);
	}

	/**
	 * @return string
	 */
	public function getAddress5()
	{
	    return $this->getData(self::ADDRESS5);
	}
	
    /**
     * @param string $address5
     */
	public function setAddress5($address5)
	{
	    $this->setData(self::ADDRESS5, (string)$address5);
	}

	/**
	 * @return string
	 */
	public function getPostcode()
	{
	    return $this->getData(self::POSTCODE);
	}
	
    /**
     * @param string $postcode
     */
	public function setPostcode($postcode)
	{
	    $this->setData(self::POSTCODE, (string)$postcode);
	}

	/**
	 * @return string
	 */
	public function getTelephoneNumber()
	{
	    return $this->getData(self::TELEPHONE_NUMBER);
	}
	
    /**
     * @param string $telephoneNumber
     */
	public function setTelephoneNumber($telephoneNumber)
	{
	    $this->setData(self::TELEPHONE_NUMBER, (string)$telephoneNumber);
	}

	/**
	 * @return string
	 */
	public function getFaxNumber()
	{
	    return $this->getData(self::FAX_NUMBER);
	}
	
    /**
     * @param string $faxNumber
     */
	public function setFaxNumber($faxNumber)
	{
	    $this->setData(self::FAX_NUMBER, (string)$faxNumber);
	}

	/**
	 * @return string
	 */
	public function getMobileNumber()
	{
	    return $this->getData(self::MOBILE_NUMBER);
	}
	
    /**
     * @param string $mobileNumber
     */
	public function setMobileNumber($mobileNumber)
	{
	    $this->setData(self::MOBILE_NUMBER, (string)$mobileNumber);
	}

	/**
	 * @return string
	 */
	public function getEmailAddress()
	{
	    return $this->getData(self::EMAIL_ADDRESS);
	}
	
    /**
     * @param string $emailAddress
     */
	public function setEmailAddress($emailAddress)
	{
	    $this->setData(self::EMAIL_ADDRESS, (string)$emailAddress);
	}

	/**
	 * @return string
	 */
	public function getCostCentre()
	{
	    return $this->getData(self::COST_CENTRE);
	}
	
    /**
     * @param string $costCentre
     */
	public function setCostCentre($costCentre)
	{
	    $this->setData(self::COST_CENTRE, (string)$costCentre);
	}

	/**
	 * @return string
	 */
	public function getDepartment()
	{
	    return $this->getData(self::DEPARTMENT);
	}
	
    /**
     * @param string $department
     */
	public function setDepartment($department)
	{
	    $this->setData(self::DEPARTMENT, (string)$department);
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
	    return $this->getData(self::PASSWORD);
	}
	
    /**
     * @param string $password
     */
	public function setPassword($password)
	{
	    $this->setData(self::PASSWORD, (string)$password);
	}

	/**
	 * @return string
	 */
	public function getCurrencyCode()
	{
	    return $this->getData(self::CURRENCY_CODE);
	}
	
    /**
     * @param string $currencyCode
     */
	public function setCurrencyCode($currencyCode)
	{
	    $this->setData(self::CURRENCY_CODE, (string)$currencyCode);
	}

	/**
	 * @return string
	 */
	public function getVatRegNumber()
	{
	    return $this->getData(self::VAT_REG_NUMBER);
	}
	
    /**
     * @param string $vatRegNumber
     */
	public function setVatRegNumber($vatRegNumber)
	{
	    $this->setData(self::VAT_REG_NUMBER, (string)$vatRegNumber);
	}

	/**
	 * @return string
	 */
	public function getContactName()
	{
	    return $this->getData(self::CONTACT_NAME);
	}
	
    /**
     * @param string $contactName
     */
	public function setContactName($contactName)
	{
	    $this->setData(self::CONTACT_NAME, (string)$contactName);
	}

	/**
	 * @return boolean
	 */
	public function getRecordUpdated()
	{
	    return $this->getData(self::RECORD_UPDATED);
	}
	
    /**
     * @param boolean $recordUpdated
     */
	public function setRecordUpdated($recordUpdated)
	{
	    $this->setData(self::RECORD_UPDATED, (boolean)$recordUpdated);
	}

}
