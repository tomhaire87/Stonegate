<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord;

interface StockRecordInterface
{
    const ENTITY_TYPE = 'stock_record';

    /**
      * @return StockRecord
      */
    public function getResource();

	/**
	 * @return int
	 */
	public function getStockId();

	/**
	 * @return string
	 */
	public function getStockCode();

	/**
	 * @return string
	 */
	public function getDescription();

	/**
	 * @return string
	 */
	public function getCategoryCodes();

	/**
	 * @return float
	 */
	public function getSellPrice();

	/**
	 * @return float
	 */
	public function getSellPriceA();

	/**
	 * @return float
	 */
	public function getSellPriceB();

	/**
	 * @return float
	 */
	public function getSellPriceC();

	/**
	 * @return float
	 */
	public function getSellPriceD();

	/**
	 * @return float
	 */
	public function getSellPriceE();

	/**
	 * @return float
	 */
	public function getSellPriceF();

	/**
	 * @return float
	 */
	public function getSellPriceG();

	/**
	 * @return float
	 */
	public function getSellPriceH();

	/**
	 * @return float
	 */
	public function getCostPrice();

	/**
	 * @return string
	 */
	public function getUnitDescription();

	/**
	 * @return string
	 */
	public function getExtendedDescription();

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
	 * @return boolean
	 */
	public function getFeaturedItem();

	/**
	 * @return boolean
	 */
	public function getNonSaleableOnWeb();

	/**
	 * @return float
	 */
	public function getWeight();

	/**
	 * @return string
	 */
	public function getImageNames();

	/**
	 * @return string
	 */
	public function getVatCode();

	/**
	 * @return float
	 */
	public function getSellPriceVatValue();

	/**
	 * @return string
	 */
	public function getSearchRef1();

	/**
	 * @return string
	 */
	public function getSearchRef2();

	/**
	 * @return float
	 */
	public function getFreeStockQuantity();

	/**
	 * @return boolean
	 */
	public function getComponentOnly();

	/**
	 * @return string
	 */
	public function getMetaTitle();

	/**
	 * @return string
	 */
	public function getMetaKeywords();

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
	public function getCustomDate1();

	/**
	 * @return string
	 */
	public function getCustomDate2();

	/**
	 * @return string
	 */
	public function getAnalysisCode();

	/**
	 * @return boolean
	 */
	public function getRecordUpdated();
}
