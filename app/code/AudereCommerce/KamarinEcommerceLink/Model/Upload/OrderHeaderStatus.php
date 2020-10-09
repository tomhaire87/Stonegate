<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusInterface;
use Magento\Framework\Model\AbstractModel;

class OrderHeaderStatus extends AbstractModel implements OrderHeaderStatusInterface
{
    const ORDER_HEADERS_STATUSES_ID = 'order_headers_statuses_id';
    const ACCOUNTS_ORDER_NUMBER = 'accounts_order_number';
    const WEB_ORDER_NUMBER = 'web_order_number';
    const ORDER_DATE = 'order_date';
    const LAST_DELIVERY_DATE = 'last_delivery_date';
    const LAST_DELIVERY_NUMBER = 'last_delivery_number';
    const ORDER_STATUS = 'order_status';
    const CUSTOM_TEXT_1 = 'custom_text_1';
    const CUSTOM_TEXT_2 = 'custom_text_2';
    const CUSTOM_TEXT_3 = 'custom_text_3';
    const CUSTOM_DATE_1 = 'custom_date_1';
    const CUSTOM_DATE_2 = 'custom_date_2';
    const CUSTOM_DATE_3 = 'custom_date_3';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus');
    }

	/**
	 * @return int
	 */
	public function getOrderHeadersStatusesId()
	{
	    return $this->getData(self::ORDER_HEADERS_STATUSES_ID);
	}
	
    /**
     * @param int $orderHeadersStatusesId
     */
	public function setOrderHeadersStatusesId($orderHeadersStatusesId)
	{
	    $this->setData(self::ORDER_HEADERS_STATUSES_ID, (int)$orderHeadersStatusesId);
	}

	/**
	 * @return string
	 */
	public function getAccountsOrderNumber()
	{
	    return $this->getData(self::ACCOUNTS_ORDER_NUMBER);
	}
	
    /**
     * @param string $accountsOrderNumber
     */
	public function setAccountsOrderNumber($accountsOrderNumber)
	{
	    $this->setData(self::ACCOUNTS_ORDER_NUMBER, (string)$accountsOrderNumber);
	}

	/**
	 * @return string
	 */
	public function getWebOrderNumber()
	{
	    return $this->getData(self::WEB_ORDER_NUMBER);
	}
	
    /**
     * @param string $webOrderNumber
     */
	public function setWebOrderNumber($webOrderNumber)
	{
	    $this->setData(self::WEB_ORDER_NUMBER, (string)$webOrderNumber);
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
	public function getLastDeliveryDate()
	{
	    return $this->getData(self::LAST_DELIVERY_DATE);
	}
	
    /**
     * @param string $lastDeliveryDate
     */
	public function setLastDeliveryDate($lastDeliveryDate)
	{
	    $this->setData(self::LAST_DELIVERY_DATE, (string)$lastDeliveryDate);
	}

	/**
	 * @return string
	 */
	public function getLastDeliveryNumber()
	{
	    return $this->getData(self::LAST_DELIVERY_NUMBER);
	}
	
    /**
     * @param string $lastDeliveryNumber
     */
	public function setLastDeliveryNumber($lastDeliveryNumber)
	{
	    $this->setData(self::LAST_DELIVERY_NUMBER, (string)$lastDeliveryNumber);
	}

	/**
	 * @return string
	 */
	public function getOrderStatus()
	{
	    return $this->getData(self::ORDER_STATUS);
	}
	
    /**
     * @param string $orderStatus
     */
	public function setOrderStatus($orderStatus)
	{
	    $this->setData(self::ORDER_STATUS, (string)$orderStatus);
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
	public function getCustomDate1()
	{
	    return $this->getData(self::CUSTOM_DATE_1);
	}
	
    /**
     * @param string $customDate1
     */
	public function setCustomDate1($customDate1)
	{
	    $this->setData(self::CUSTOM_DATE_1, (string)$customDate1);
	}

	/**
	 * @return string
	 */
	public function getCustomDate2()
	{
	    return $this->getData(self::CUSTOM_DATE_2);
	}
	
    /**
     * @param string $customDate2
     */
	public function setCustomDate2($customDate2)
	{
	    $this->setData(self::CUSTOM_DATE_2, (string)$customDate2);
	}

	/**
	 * @return string
	 */
	public function getCustomDate3()
	{
	    return $this->getData(self::CUSTOM_DATE_3);
	}
	
    /**
     * @param string $customDate3
     */
	public function setCustomDate3($customDate3)
	{
	    $this->setData(self::CUSTOM_DATE_3, (string)$customDate3);
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
