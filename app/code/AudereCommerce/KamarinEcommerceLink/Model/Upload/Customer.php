<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerInterface;
use Magento\Framework\Model\AbstractModel;

class Customer extends AbstractModel implements CustomerInterface
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
    const EMAIL_ADDRESS = 'email_address';
    const PASSWORD = 'password';
    const PRICE_LIST_CODE = 'price_list_code';
    const ON_STOP = 'on_stop';
    const VAT_CODE = 'vat_code';
    const USER_FIELD_1 = 'user_field_1';
    const USER_FIELD_2 = 'user_field_2';
    const USER_FIELD_3 = 'user_field_3';
    const USER_FIELD_4 = 'user_field_4';
    const USER_FIELD_5 = 'user_field_5';
    const USER_FIELD_6 = 'user_field_6';
    const USER_FIELD_7 = 'user_field_7';
    const USER_FIELD_8 = 'user_field_8';
    const USER_FIELD_9 = 'user_field_9';
    const USER_FIELD_10 = 'user_field_10';
    const PRICE_BAND = 'price_band';
    const CREDIT_LIMIT = 'credit_limit';
    const ACCOUNT_BALANCE = 'account_balance';
    const ORDER_BALANCE = 'order_balance';
    const CUSTOMER_TYPE = 'customer_type';
    const DISCOUNT_CODE = 'discount_code';
    const CUSTOM_TEXT_1 = 'custom_text_1';
    const CUSTOM_TEXT_2 = 'custom_text_2';
    const CUSTOM_TEXT_3 = 'custom_text_3';
    const CUSTOM_TEXT_4 = 'custom_text_4';
    const CUSTOM_TEXT_5 = 'custom_text_5';
    const CURRENCY_CODE = 'currency_code';
    const COUNTRY_CODE = 'country_code';
    const INVOICE_ACCOUNT = 'invoice_account';
    const VAT_REG_NUMBER = 'vat_reg_number';
    const MOBILE_NUMBER = 'mobile_number';
    const DISCOUNT_PERCENTAGE = 'discount_percentage';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer');
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
	public function getPriceListCode()
	{
	    return $this->getData(self::PRICE_LIST_CODE);
	}
	
    /**
     * @param string $priceListCode
     */
	public function setPriceListCode($priceListCode)
	{
	    $this->setData(self::PRICE_LIST_CODE, (string)$priceListCode);
	}

	/**
	 * @return boolean
	 */
	public function getOnStop()
	{
	    return $this->getData(self::ON_STOP);
	}
	
    /**
     * @param boolean $onStop
     */
	public function setOnStop($onStop)
	{
	    $this->setData(self::ON_STOP, (boolean)$onStop);
	}

	/**
	 * @return string
	 */
	public function getVatCode()
	{
	    return $this->getData(self::VAT_CODE);
	}
	
    /**
     * @param string $vatCode
     */
	public function setVatCode($vatCode)
	{
	    $this->setData(self::VAT_CODE, (string)$vatCode);
	}

	/**
	 * @return string
	 */
	public function getUserField1()
	{
	    return $this->getData(self::USER_FIELD_1);
	}
	
    /**
     * @param string $userField1
     */
	public function setUserField1($userField1)
	{
	    $this->setData(self::USER_FIELD_1, (string)$userField1);
	}

	/**
	 * @return string
	 */
	public function getUserField2()
	{
	    return $this->getData(self::USER_FIELD_2);
	}
	
    /**
     * @param string $userField2
     */
	public function setUserField2($userField2)
	{
	    $this->setData(self::USER_FIELD_2, (string)$userField2);
	}

	/**
	 * @return string
	 */
	public function getUserField3()
	{
	    return $this->getData(self::USER_FIELD_3);
	}
	
    /**
     * @param string $userField3
     */
	public function setUserField3($userField3)
	{
	    $this->setData(self::USER_FIELD_3, (string)$userField3);
	}

	/**
	 * @return string
	 */
	public function getUserField4()
	{
	    return $this->getData(self::USER_FIELD_4);
	}
	
    /**
     * @param string $userField4
     */
	public function setUserField4($userField4)
	{
	    $this->setData(self::USER_FIELD_4, (string)$userField4);
	}

	/**
	 * @return string
	 */
	public function getUserField5()
	{
	    return $this->getData(self::USER_FIELD_5);
	}
	
    /**
     * @param string $userField5
     */
	public function setUserField5($userField5)
	{
	    $this->setData(self::USER_FIELD_5, (string)$userField5);
	}

	/**
	 * @return string
	 */
	public function getUserField6()
	{
	    return $this->getData(self::USER_FIELD_6);
	}
	
    /**
     * @param string $userField6
     */
	public function setUserField6($userField6)
	{
	    $this->setData(self::USER_FIELD_6, (string)$userField6);
	}

	/**
	 * @return string
	 */
	public function getUserField7()
	{
	    return $this->getData(self::USER_FIELD_7);
	}
	
    /**
     * @param string $userField7
     */
	public function setUserField7($userField7)
	{
	    $this->setData(self::USER_FIELD_7, (string)$userField7);
	}

	/**
	 * @return string
	 */
	public function getUserField8()
	{
	    return $this->getData(self::USER_FIELD_8);
	}
	
    /**
     * @param string $userField8
     */
	public function setUserField8($userField8)
	{
	    $this->setData(self::USER_FIELD_8, (string)$userField8);
	}

	/**
	 * @return string
	 */
	public function getUserField9()
	{
	    return $this->getData(self::USER_FIELD_9);
	}
	
    /**
     * @param string $userField9
     */
	public function setUserField9($userField9)
	{
	    $this->setData(self::USER_FIELD_9, (string)$userField9);
	}

	/**
	 * @return string
	 */
	public function getUserField10()
	{
	    return $this->getData(self::USER_FIELD_10);
	}
	
    /**
     * @param string $userField10
     */
	public function setUserField10($userField10)
	{
	    $this->setData(self::USER_FIELD_10, (string)$userField10);
	}

	/**
	 * @return string
	 */
	public function getPriceBand()
	{
	    return $this->getData(self::PRICE_BAND);
	}
	
    /**
     * @param string $priceBand
     */
	public function setPriceBand($priceBand)
	{
	    $this->setData(self::PRICE_BAND, (string)$priceBand);
	}

	/**
	 * @return float
	 */
	public function getCreditLimit()
	{
	    return $this->getData(self::CREDIT_LIMIT);
	}
	
    /**
     * @param float $creditLimit
     */
	public function setCreditLimit($creditLimit)
	{
	    $this->setData(self::CREDIT_LIMIT, (float)$creditLimit);
	}

	/**
	 * @return float
	 */
	public function getAccountBalance()
	{
	    return $this->getData(self::ACCOUNT_BALANCE);
	}
	
    /**
     * @param float $accountBalance
     */
	public function setAccountBalance($accountBalance)
	{
	    $this->setData(self::ACCOUNT_BALANCE, (float)$accountBalance);
	}

	/**
	 * @return float
	 */
	public function getOrderBalance()
	{
	    return $this->getData(self::ORDER_BALANCE);
	}
	
    /**
     * @param float $orderBalance
     */
	public function setOrderBalance($orderBalance)
	{
	    $this->setData(self::ORDER_BALANCE, (float)$orderBalance);
	}

	/**
	 * @return string
	 */
	public function getCustomerType()
	{
	    return $this->getData(self::CUSTOMER_TYPE);
	}
	
    /**
     * @param string $customerType
     */
	public function setCustomerType($customerType)
	{
	    $this->setData(self::CUSTOMER_TYPE, (string)$customerType);
	}

	/**
	 * @return string
	 */
	public function getDiscountCode()
	{
	    return $this->getData(self::DISCOUNT_CODE);
	}
	
    /**
     * @param string $discountCode
     */
	public function setDiscountCode($discountCode)
	{
	    $this->setData(self::DISCOUNT_CODE, (string)$discountCode);
	}

	/**
	 * @return string
	 */
	public function getCustomText1()
	{
	    return $this->getData(self::CUSTOM_TEXT_1);
	}
	
    /**
     * @param string $customText1
     */
	public function setCustomText1($customText1)
	{
	    $this->setData(self::CUSTOM_TEXT_1, (string)$customText1);
	}

	/**
	 * @return string
	 */
	public function getCustomText2()
	{
	    return $this->getData(self::CUSTOM_TEXT_2);
	}
	
    /**
     * @param string $customText2
     */
	public function setCustomText2($customText2)
	{
	    $this->setData(self::CUSTOM_TEXT_2, (string)$customText2);
	}

	/**
	 * @return string
	 */
	public function getCustomText3()
	{
	    return $this->getData(self::CUSTOM_TEXT_3);
	}
	
    /**
     * @param string $customText3
     */
	public function setCustomText3($customText3)
	{
	    $this->setData(self::CUSTOM_TEXT_3, (string)$customText3);
	}

	/**
	 * @return string
	 */
	public function getCustomText4()
	{
	    return $this->getData(self::CUSTOM_TEXT_4);
	}
	
    /**
     * @param string $customText4
     */
	public function setCustomText4($customText4)
	{
	    $this->setData(self::CUSTOM_TEXT_4, (string)$customText4);
	}

	/**
	 * @return string
	 */
	public function getCustomText5()
	{
	    return $this->getData(self::CUSTOM_TEXT_5);
	}
	
    /**
     * @param string $customText5
     */
	public function setCustomText5($customText5)
	{
	    $this->setData(self::CUSTOM_TEXT_5, (string)$customText5);
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
	public function getCountryCode()
	{
	    return $this->getData(self::COUNTRY_CODE);
	}
	
    /**
     * @param string $countryCode
     */
	public function setCountryCode($countryCode)
	{
	    $this->setData(self::COUNTRY_CODE, (string)$countryCode);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAccount()
	{
	    return $this->getData(self::INVOICE_ACCOUNT);
	}
	
    /**
     * @param string $invoiceAccount
     */
	public function setInvoiceAccount($invoiceAccount)
	{
	    $this->setData(self::INVOICE_ACCOUNT, (string)$invoiceAccount);
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
	 * @return float
	 */
	public function getDiscountPercentage()
	{
	    return $this->getData(self::DISCOUNT_PERCENTAGE);
	}
	
    /**
     * @param float $discountPercentage
     */
	public function setDiscountPercentage($discountPercentage)
	{
	    $this->setData(self::DISCOUNT_PERCENTAGE, (float)$discountPercentage);
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
