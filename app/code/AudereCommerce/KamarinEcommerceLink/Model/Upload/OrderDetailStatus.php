<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusInterface;
use Magento\Framework\Model\AbstractModel;

class OrderDetailStatus extends AbstractModel implements OrderDetailStatusInterface
{
    const ORDER_DETAILS_STATUSES_ID = 'order_details_statuses_id';
    const ACCOUNTS_ORDER_NUMBER = 'accounts_order_number';
    const STOCK_CODE = 'stock_code';
    const DESCRIPTION = 'description';
    const ORDERED_QUANTITY = 'ordered_quantity';
    const DELIVERED_QUANTITY = 'delivered_quantity';
    const ORDER_LINE_STATUS = 'order_line_status';
    const CUSTOM_TEXT_1 = 'custom_text_1';
    const CUSTOM_TEXT_2 = 'custom_text_2';
    const CUSTOM_TEXT_3 = 'custom_text_3';
    const CUSTOM_DATE_1 = 'custom_date_1';
    const CUSTOM_DATE_2 = 'custom_date_2';
    const CUSTOM_DATE_3 = 'custom_date_3';
    const ORIGINAL_WEB_ORDER_LINE_ID = 'original_web_order_line_id';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus');
    }

	/**
	 * @return int
	 */
	public function getOrderDetailsStatusesId()
	{
	    return $this->getData(self::ORDER_DETAILS_STATUSES_ID);
	}
	
    /**
     * @param int $orderDetailsStatusesId
     */
	public function setOrderDetailsStatusesId($orderDetailsStatusesId)
	{
	    $this->setData(self::ORDER_DETAILS_STATUSES_ID, (int)$orderDetailsStatusesId);
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
	public function getStockCode()
	{
	    return $this->getData(self::STOCK_CODE);
	}
	
    /**
     * @param string $stockCode
     */
	public function setStockCode($stockCode)
	{
	    $this->setData(self::STOCK_CODE, (string)$stockCode);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
	    return $this->getData(self::DESCRIPTION);
	}
	
    /**
     * @param string $description
     */
	public function setDescription($description)
	{
	    $this->setData(self::DESCRIPTION, (string)$description);
	}

	/**
	 * @return float
	 */
	public function getOrderedQuantity()
	{
	    return $this->getData(self::ORDERED_QUANTITY);
	}
	
    /**
     * @param float $orderedQuantity
     */
	public function setOrderedQuantity($orderedQuantity)
	{
	    $this->setData(self::ORDERED_QUANTITY, (float)$orderedQuantity);
	}

	/**
	 * @return float
	 */
	public function getDeliveredQuantity()
	{
	    return $this->getData(self::DELIVERED_QUANTITY);
	}
	
    /**
     * @param float $deliveredQuantity
     */
	public function setDeliveredQuantity($deliveredQuantity)
	{
	    $this->setData(self::DELIVERED_QUANTITY, (float)$deliveredQuantity);
	}

	/**
	 * @return string
	 */
	public function getOrderLineStatus()
	{
	    return $this->getData(self::ORDER_LINE_STATUS);
	}
	
    /**
     * @param string $orderLineStatus
     */
	public function setOrderLineStatus($orderLineStatus)
	{
	    $this->setData(self::ORDER_LINE_STATUS, (string)$orderLineStatus);
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
	 * @return float
	 */
	public function getOriginalWebOrderLineId()
	{
	    return $this->getData(self::ORIGINAL_WEB_ORDER_LINE_ID);
	}
	
    /**
     * @param float $originalWebOrderLineId
     */
	public function setOriginalWebOrderLineId($originalWebOrderLineId)
	{
	    $this->setData(self::ORIGINAL_WEB_ORDER_LINE_ID, (float)$originalWebOrderLineId);
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
