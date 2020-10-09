<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceInterface;
use Magento\Framework\Model\AbstractModel;

class CustomerSpecialPrice extends AbstractModel implements CustomerSpecialPriceInterface
{
    const SPECIAL_PRICE_ID = 'special_price_id';
    const PRICE_LIST_CODE = 'price_list_code';
    const STOCK_CODE = 'stock_code';
    const SPECIAL_PRICE = 'special_price';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice');
    }

	/**
	 * @return int
	 */
	public function getSpecialPriceId()
	{
	    return $this->getData(self::SPECIAL_PRICE_ID);
	}

    /**
     * @param int $specialPriceId
     */
	public function setSpecialPriceId($specialPriceId)
	{
	    $this->setData(self::SPECIAL_PRICE_ID, (int)$specialPriceId);
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
