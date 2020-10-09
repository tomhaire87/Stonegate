<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceInterface;
use Magento\Framework\Model\AbstractModel;

class QuantityBreakSpecialPrice extends AbstractModel implements QuantityBreakSpecialPriceInterface
{
    const QTY_BREAK_PRICE_ID = 'qty_break_price_id';
    const PRICE_LIST_CODE = 'price_list_code';
    const STOCK_CODE = 'stock_code';
    const FROM_QTY = 'from_qty';
    const TO_QTY = 'to_qty';
    const SPECIAL_PRICE = 'special_price';
    const PRIORITY = 'priority';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice');
    }

	/**
	 * @return int
	 */
	public function getQtyBreakPriceId()
	{
	    return $this->getData(self::QTY_BREAK_PRICE_ID);
	}
	
    /**
     * @param int $qtyBreakPriceId
     */
	public function setQtyBreakPriceId($qtyBreakPriceId)
	{
	    $this->setData(self::QTY_BREAK_PRICE_ID, (int)$qtyBreakPriceId);
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
	 * @return float
	 */
	public function getFromQty()
	{
	    return $this->getData(self::FROM_QTY);
	}
	
    /**
     * @param float $fromQty
     */
	public function setFromQty($fromQty)
	{
	    $this->setData(self::FROM_QTY, (float)$fromQty);
	}

	/**
	 * @return float
	 */
	public function getToQty()
	{
	    return $this->getData(self::TO_QTY);
	}
	
    /**
     * @param float $toQty
     */
	public function setToQty($toQty)
	{
	    $this->setData(self::TO_QTY, (float)$toQty);
	}

	/**
	 * @return float
	 */
	public function getSpecialPrice()
	{
	    return $this->getData(self::SPECIAL_PRICE);
	}
	
    /**
     * @param float $specialPrice
     */
	public function setSpecialPrice($specialPrice)
	{
	    $this->setData(self::SPECIAL_PRICE, (float)$specialPrice);
	}

	/**
	 * @return int
	 */
	public function getPriority()
	{
	    return $this->getData(self::PRIORITY);
	}
	
    /**
     * @param int $priority
     */
	public function setPriority($priority)
	{
	    $this->setData(self::PRIORITY, (int)$priority);
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
