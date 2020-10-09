<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailInterface;
use Magento\Framework\Model\AbstractModel;

class OrderDetail extends AbstractModel implements OrderDetailInterface
{
    const ORDER_DETAILS_ID = 'order_details_id';
    const ORDER_HEADER_ID = 'order_header_id';
    const STOCK_CODE = 'stock_code';
    const DESCRIPTION = 'description';
    const UNIT_NETT_PRICE = 'unit_nett_price';
    const QUANTITY_SOLD = 'quantity_sold';
    const LINE_NETT_VALUE = 'line_nett_value';
    const LINE_VAT_VALUE = 'line_vat_value';
    const VAT_CODE = 'vat_code';
    const VAT_RATE = 'vat_rate';
    const ORIGINAL_WEB_ORDER_LINE_ID = 'original_web_order_line_id';
    const LOCATION_CODE = 'location_code';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail');
    }

	/**
	 * @return int
	 */
	public function getOrderDetailsId()
	{
	    return $this->getData(self::ORDER_DETAILS_ID);
	}
	
    /**
     * @param int $orderDetailsId
     */
	public function setOrderDetailsId($orderDetailsId)
	{
	    $this->setData(self::ORDER_DETAILS_ID, (int)$orderDetailsId);
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
	public function getUnitNettPrice()
	{
	    return $this->getData(self::UNIT_NETT_PRICE);
	}
	
    /**
     * @param float $unitNettPrice
     */
	public function setUnitNettPrice($unitNettPrice)
	{
	    $this->setData(self::UNIT_NETT_PRICE, (float)$unitNettPrice);
	}

	/**
	 * @return float
	 */
	public function getQuantitySold()
	{
	    return $this->getData(self::QUANTITY_SOLD);
	}
	
    /**
     * @param float $quantitySold
     */
	public function setQuantitySold($quantitySold)
	{
	    $this->setData(self::QUANTITY_SOLD, (float)$quantitySold);
	}

	/**
	 * @return float
	 */
	public function getLineNettValue()
	{
	    return $this->getData(self::LINE_NETT_VALUE);
	}
	
    /**
     * @param float $lineNettValue
     */
	public function setLineNettValue($lineNettValue)
	{
	    $this->setData(self::LINE_NETT_VALUE, (float)$lineNettValue);
	}

	/**
	 * @return float
	 */
	public function getLineVatValue()
	{
	    return $this->getData(self::LINE_VAT_VALUE);
	}
	
    /**
     * @param float $lineVatValue
     */
	public function setLineVatValue($lineVatValue)
	{
	    $this->setData(self::LINE_VAT_VALUE, (float)$lineVatValue);
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
	 * @return float
	 */
	public function getVatRate()
	{
	    return $this->getData(self::VAT_RATE);
	}
	
    /**
     * @param float $vatRate
     */
	public function setVatRate($vatRate)
	{
	    $this->setData(self::VAT_RATE, (float)$vatRate);
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

}
