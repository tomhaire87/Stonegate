<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderInterface;
use Magento\Framework\Model\AbstractModel;

class OrderHeader extends AbstractModel implements OrderHeaderInterface
{
    const ORDER_HEADER_ID = 'order_header_id';
    const ORDER_NUMBER = 'order_number';
    const ORDER_DATE = 'order_date';
    const INVOICE_NAME = 'invoice_name';
    const INVOICE_ADDRESS_1 = 'invoice_address_1';
    const INVOICE_ADDRESS_2 = 'invoice_address_2';
    const INVOICE_ADDRESS_3 = 'invoice_address_3';
    const INVOICE_ADDRESS_4 = 'invoice_address_4';
    const INVOICE_ADDRESS_5 = 'invoice_address_5';
    const INVOICE_POSTCODE = 'invoice_postcode';
    const DELIVERY_NAME = 'delivery_name';
    const DELIVERY_ADDRESS_1 = 'delivery_address_1';
    const DELIVERY_ADDRESS_2 = 'delivery_address_2';
    const DELIVERY_ADDRESS_3 = 'delivery_address_3';
    const DELIVERY_ADDRESS_4 = 'delivery_address_4';
    const DELIVERY_ADDRESS_5 = 'delivery_address_5';
    const DELIVERY_POSTCODE = 'delivery_postcode';
    const DELIVERY_TELEPHONE_NUMBER = 'delivery_telephone_number';
    const DELIVERY_FAX_NUMBER = 'delivery_fax_number';
    const EMAIL_ADDRESS = 'email_address';
    const SALES_LEDGER_ACCOUNT_CODE = 'sales_ledger_account_code';
    const COMMENTS = 'comments';
    const CUSTOMER_REFERENCE_NUMBER = 'customer_reference_number';
    const SHIPPING_METHOD = 'shipping_method';
    const PAYMENT_WITH_ORDER = 'payment_with_order';
    const PAYMENT_METHOD = 'payment_method';
    const LOCATION_CODE = 'location_code';
    const CURRENCY_CODE = 'currency_code';
    const ORDER_GROSS_TOTAL = 'order_gross_total';
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
    const EXCHANGE_RATE = 'exchange_rate';
    const PAYMENT_CODE_1 = 'payment_code_1';
    const PAYMENT_VALUE_1 = 'payment_value_1';
    const PAYMENT_CODE_2 = 'payment_code_2';
    const PAYMENT_VALUE_2 = 'payment_value_2';
    const PAYMENT_CODE_3 = 'payment_code_3';
    const PAYMENT_VALUE_3 = 'payment_value_3';
    const PAYMENT_CODE_4 = 'payment_code_4';
    const PAYMENT_VALUE_4 = 'payment_value_4';
    const PAYMENT_CODE_5 = 'payment_code_5';
    const PAYMENT_VALUE_5 = 'payment_value_5';
    const DISCOUNT_PERCENTAGE = 'discount_percentage';
    const TAG_NUMBER = 'tag_number';
    const RECORD_DOWNLOADED = 'record_downloaded';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader');
    }

	/**
	 * @return int
	 */
	public function getOrderHeaderId()
	{
	    return $this->getData(self::ORDER_HEADER_ID);
	}
	
    /**
     * @param int $orderHeaderId
     */
	public function setOrderHeaderId($orderHeaderId)
	{
	    $this->setData(self::ORDER_HEADER_ID, (int)$orderHeaderId);
	}

	/**
	 * @return string
	 */
	public function getOrderNumber()
	{
	    return $this->getData(self::ORDER_NUMBER);
	}
	
    /**
     * @param string $orderNumber
     */
	public function setOrderNumber($orderNumber)
	{
	    $this->setData(self::ORDER_NUMBER, (string)$orderNumber);
	}

	/**
	 * @return string
	 */
	public function getOrderDate()
	{
	    return $this->getData(self::ORDER_DATE);
	}
	
    /**
     * @param string $orderDate
     */
	public function setOrderDate($orderDate)
	{
	    $this->setData(self::ORDER_DATE, (string)$orderDate);
	}

	/**
	 * @return string
	 */
	public function getInvoiceName()
	{
	    return $this->getData(self::INVOICE_NAME);
	}
	
    /**
     * @param string $invoiceName
     */
	public function setInvoiceName($invoiceName)
	{
	    $this->setData(self::INVOICE_NAME, (string)$invoiceName);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAddress1()
	{
	    return $this->getData(self::INVOICE_ADDRESS_1);
	}
	
    /**
     * @param string $invoiceAddress1
     */
	public function setInvoiceAddress1($invoiceAddress1)
	{
	    $this->setData(self::INVOICE_ADDRESS_1, (string)$invoiceAddress1);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAddress2()
	{
	    return $this->getData(self::INVOICE_ADDRESS_2);
	}
	
    /**
     * @param string $invoiceAddress2
     */
	public function setInvoiceAddress2($invoiceAddress2)
	{
	    $this->setData(self::INVOICE_ADDRESS_2, (string)$invoiceAddress2);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAddress3()
	{
	    return $this->getData(self::INVOICE_ADDRESS_3);
	}
	
    /**
     * @param string $invoiceAddress3
     */
	public function setInvoiceAddress3($invoiceAddress3)
	{
	    $this->setData(self::INVOICE_ADDRESS_3, (string)$invoiceAddress3);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAddress4()
	{
	    return $this->getData(self::INVOICE_ADDRESS_4);
	}
	
    /**
     * @param string $invoiceAddress4
     */
	public function setInvoiceAddress4($invoiceAddress4)
	{
	    $this->setData(self::INVOICE_ADDRESS_4, (string)$invoiceAddress4);
	}

	/**
	 * @return string
	 */
	public function getInvoiceAddress5()
	{
	    return $this->getData(self::INVOICE_ADDRESS_5);
	}
	
    /**
     * @param string $invoiceAddress5
     */
	public function setInvoiceAddress5($invoiceAddress5)
	{
	    $this->setData(self::INVOICE_ADDRESS_5, (string)$invoiceAddress5);
	}

	/**
	 * @return string
	 */
	public function getInvoicePostcode()
	{
	    return $this->getData(self::INVOICE_POSTCODE);
	}
	
    /**
     * @param string $invoicePostcode
     */
	public function setInvoicePostcode($invoicePostcode)
	{
	    $this->setData(self::INVOICE_POSTCODE, (string)$invoicePostcode);
	}

	/**
	 * @return string
	 */
	public function getDeliveryName()
	{
	    return $this->getData(self::DELIVERY_NAME);
	}
	
    /**
     * @param string $deliveryName
     */
	public function setDeliveryName($deliveryName)
	{
	    $this->setData(self::DELIVERY_NAME, (string)$deliveryName);
	}

	/**
	 * @return string
	 */
	public function getDeliveryAddress1()
	{
	    return $this->getData(self::DELIVERY_ADDRESS_1);
	}
	
    /**
     * @param string $deliveryAddress1
     */
	public function setDeliveryAddress1($deliveryAddress1)
	{
	    $this->setData(self::DELIVERY_ADDRESS_1, (string)$deliveryAddress1);
	}

	/**
	 * @return string
	 */
	public function getDeliveryAddress2()
	{
	    return $this->getData(self::DELIVERY_ADDRESS_2);
	}
	
    /**
     * @param string $deliveryAddress2
     */
	public function setDeliveryAddress2($deliveryAddress2)
	{
	    $this->setData(self::DELIVERY_ADDRESS_2, (string)$deliveryAddress2);
	}

	/**
	 * @return string
	 */
	public function getDeliveryAddress3()
	{
	    return $this->getData(self::DELIVERY_ADDRESS_3);
	}
	
    /**
     * @param string $deliveryAddress3
     */
	public function setDeliveryAddress3($deliveryAddress3)
	{
	    $this->setData(self::DELIVERY_ADDRESS_3, (string)$deliveryAddress3);
	}

	/**
	 * @return string
	 */
	public function getDeliveryAddress4()
	{
	    return $this->getData(self::DELIVERY_ADDRESS_4);
	}
	
    /**
     * @param string $deliveryAddress4
     */
	public function setDeliveryAddress4($deliveryAddress4)
	{
	    $this->setData(self::DELIVERY_ADDRESS_4, (string)$deliveryAddress4);
	}

	/**
	 * @return string
	 */
	public function getDeliveryAddress5()
	{
	    return $this->getData(self::DELIVERY_ADDRESS_5);
	}
	
    /**
     * @param string $deliveryAddress5
     */
	public function setDeliveryAddress5($deliveryAddress5)
	{
	    $this->setData(self::DELIVERY_ADDRESS_5, (string)$deliveryAddress5);
	}

	/**
	 * @return string
	 */
	public function getDeliveryPostcode()
	{
	    return $this->getData(self::DELIVERY_POSTCODE);
	}
	
    /**
     * @param string $deliveryPostcode
     */
	public function setDeliveryPostcode($deliveryPostcode)
	{
	    $this->setData(self::DELIVERY_POSTCODE, (string)$deliveryPostcode);
	}

	/**
	 * @return string
	 */
	public function getDeliveryTelephoneNumber()
	{
	    return $this->getData(self::DELIVERY_TELEPHONE_NUMBER);
	}
	
    /**
     * @param string $deliveryTelephoneNumber
     */
	public function setDeliveryTelephoneNumber($deliveryTelephoneNumber)
	{
	    $this->setData(self::DELIVERY_TELEPHONE_NUMBER, (string)$deliveryTelephoneNumber);
	}

	/**
	 * @return string
	 */
	public function getDeliveryFaxNumber()
	{
	    return $this->getData(self::DELIVERY_FAX_NUMBER);
	}
	
    /**
     * @param string $deliveryFaxNumber
     */
	public function setDeliveryFaxNumber($deliveryFaxNumber)
	{
	    $this->setData(self::DELIVERY_FAX_NUMBER, (string)$deliveryFaxNumber);
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
	public function getSalesLedgerAccountCode()
	{
	    return $this->getData(self::SALES_LEDGER_ACCOUNT_CODE);
	}
	
    /**
     * @param string $salesLedgerAccountCode
     */
	public function setSalesLedgerAccountCode($salesLedgerAccountCode)
	{
	    $this->setData(self::SALES_LEDGER_ACCOUNT_CODE, (string)$salesLedgerAccountCode);
	}

	/**
	 * @return string
	 */
	public function getComments()
	{
	    return $this->getData(self::COMMENTS);
	}
	
    /**
     * @param string $comments
     */
	public function setComments($comments)
	{
	    $this->setData(self::COMMENTS, (string)$comments);
	}

	/**
	 * @return string
	 */
	public function getCustomerReferenceNumber()
	{
	    return $this->getData(self::CUSTOMER_REFERENCE_NUMBER);
	}
	
    /**
     * @param string $customerReferenceNumber
     */
	public function setCustomerReferenceNumber($customerReferenceNumber)
	{
	    $this->setData(self::CUSTOMER_REFERENCE_NUMBER, (string)$customerReferenceNumber);
	}

	/**
	 * @return string
	 */
	public function getShippingMethod()
	{
	    return $this->getData(self::SHIPPING_METHOD);
	}
	
    /**
     * @param string $shippingMethod
     */
	public function setShippingMethod($shippingMethod)
	{
	    $this->setData(self::SHIPPING_METHOD, (string)$shippingMethod);
	}

	/**
	 * @return boolean
	 */
	public function getPaymentWithOrder()
	{
	    return $this->getData(self::PAYMENT_WITH_ORDER);
	}
	
    /**
     * @param boolean $paymentWithOrder
     */
	public function setPaymentWithOrder($paymentWithOrder)
	{
	    $this->setData(self::PAYMENT_WITH_ORDER, (boolean)$paymentWithOrder);
	}

	/**
	 * @return string
	 */
	public function getPaymentMethod()
	{
	    return $this->getData(self::PAYMENT_METHOD);
	}
	
    /**
     * @param string $paymentMethod
     */
	public function setPaymentMethod($paymentMethod)
	{
	    $this->setData(self::PAYMENT_METHOD, (string)$paymentMethod);
	}

	/**
	 * @return string
	 */
	public function getLocationCode()
	{
	    return $this->getData(self::LOCATION_CODE);
	}
	
    /**
     * @param string $locationCode
     */
	public function setLocationCode($locationCode)
	{
	    $this->setData(self::LOCATION_CODE, (string)$locationCode);
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
	 * @return float
	 */
	public function getOrderGrossTotal()
	{
	    return $this->getData(self::ORDER_GROSS_TOTAL);
	}
	
    /**
     * @param float $orderGrossTotal
     */
	public function setOrderGrossTotal($orderGrossTotal)
	{
	    $this->setData(self::ORDER_GROSS_TOTAL, (float)$orderGrossTotal);
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
	 * @return float
	 */
	public function getExchangeRate()
	{
	    return $this->getData(self::EXCHANGE_RATE);
	}
	
    /**
     * @param float $exchangeRate
     */
	public function setExchangeRate($exchangeRate)
	{
	    $this->setData(self::EXCHANGE_RATE, (float)$exchangeRate);
	}

	/**
	 * @return string
	 */
	public function getPaymentCode1()
	{
	    return $this->getData(self::PAYMENT_CODE_1);
	}
	
    /**
     * @param string $paymentCode1
     */
	public function setPaymentCode1($paymentCode1)
	{
	    $this->setData(self::PAYMENT_CODE_1, (string)$paymentCode1);
	}

	/**
	 * @return float
	 */
	public function getPaymentValue1()
	{
	    return $this->getData(self::PAYMENT_VALUE_1);
	}
	
    /**
     * @param float $paymentValue1
     */
	public function setPaymentValue1($paymentValue1)
	{
	    $this->setData(self::PAYMENT_VALUE_1, (float)$paymentValue1);
	}

	/**
	 * @return string
	 */
	public function getPaymentCode2()
	{
	    return $this->getData(self::PAYMENT_CODE_2);
	}
	
    /**
     * @param string $paymentCode2
     */
	public function setPaymentCode2($paymentCode2)
	{
	    $this->setData(self::PAYMENT_CODE_2, (string)$paymentCode2);
	}

	/**
	 * @return float
	 */
	public function getPaymentValue2()
	{
	    return $this->getData(self::PAYMENT_VALUE_2);
	}
	
    /**
     * @param float $paymentValue2
     */
	public function setPaymentValue2($paymentValue2)
	{
	    $this->setData(self::PAYMENT_VALUE_2, (float)$paymentValue2);
	}

	/**
	 * @return string
	 */
	public function getPaymentCode3()
	{
	    return $this->getData(self::PAYMENT_CODE_3);
	}
	
    /**
     * @param string $paymentCode3
     */
	public function setPaymentCode3($paymentCode3)
	{
	    $this->setData(self::PAYMENT_CODE_3, (string)$paymentCode3);
	}

	/**
	 * @return float
	 */
	public function getPaymentValue3()
	{
	    return $this->getData(self::PAYMENT_VALUE_3);
	}
	
    /**
     * @param float $paymentValue3
     */
	public function setPaymentValue3($paymentValue3)
	{
	    $this->setData(self::PAYMENT_VALUE_3, (float)$paymentValue3);
	}

	/**
	 * @return string
	 */
	public function getPaymentCode4()
	{
	    return $this->getData(self::PAYMENT_CODE_4);
	}
	
    /**
     * @param string $paymentCode4
     */
	public function setPaymentCode4($paymentCode4)
	{
	    $this->setData(self::PAYMENT_CODE_4, (string)$paymentCode4);
	}

	/**
	 * @return float
	 */
	public function getPaymentValue4()
	{
	    return $this->getData(self::PAYMENT_VALUE_4);
	}
	
    /**
     * @param float $paymentValue4
     */
	public function setPaymentValue4($paymentValue4)
	{
	    $this->setData(self::PAYMENT_VALUE_4, (float)$paymentValue4);
	}

	/**
	 * @return string
	 */
	public function getPaymentCode5()
	{
	    return $this->getData(self::PAYMENT_CODE_5);
	}
	
    /**
     * @param string $paymentCode5
     */
	public function setPaymentCode5($paymentCode5)
	{
	    $this->setData(self::PAYMENT_CODE_5, (string)$paymentCode5);
	}

	/**
	 * @return float
	 */
	public function getPaymentValue5()
	{
	    return $this->getData(self::PAYMENT_VALUE_5);
	}
	
    /**
     * @param float $paymentValue5
     */
	public function setPaymentValue5($paymentValue5)
	{
	    $this->setData(self::PAYMENT_VALUE_5, (float)$paymentValue5);
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
	 * @return float
	 */
	public function getTagNumber()
	{
	    return $this->getData(self::TAG_NUMBER);
	}
	
    /**
     * @param float $tagNumber
     */
	public function setTagNumber($tagNumber)
	{
	    $this->setData(self::TAG_NUMBER, (float)$tagNumber);
	}

	/**
	 * @return boolean
	 */
	public function getRecordDownloaded()
	{
	    return $this->getData(self::RECORD_DOWNLOADED);
	}
	
    /**
     * @param boolean $recordDownloaded
     */
	public function setRecordDownloaded($recordDownloaded)
	{
	    $this->setData(self::RECORD_DOWNLOADED, (boolean)$recordDownloaded);
	}

}
