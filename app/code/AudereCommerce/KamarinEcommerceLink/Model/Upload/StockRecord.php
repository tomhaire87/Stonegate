<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordInterface;
use Magento\Framework\Model\AbstractModel;

class StockRecord extends AbstractModel implements StockRecordInterface
{
    const STOCK_ID = 'stock_id';
    const STOCK_CODE = 'stock_code';
    const DESCRIPTION = 'description';
    const CATEGORY_CODES = 'category_codes';
    const SELL_PRICE = 'sell_price';
    const SELL_PRICE_A = 'sell_price_a';
    const SELL_PRICE_B = 'sell_price_b';
    const SELL_PRICE_C = 'sell_price_c';
    const SELL_PRICE_D = 'sell_price_d';
    const SELL_PRICE_E = 'sell_price_e';
    const SELL_PRICE_F = 'sell_price_f';
    const SELL_PRICE_G = 'sell_price_g';
    const SELL_PRICE_H = 'sell_price_h';
    const COST_PRICE = 'cost_price';
    const UNIT_DESCRIPTION = 'unit_description';
    const EXTENDED_DESCRIPTION = 'extended_description';
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
    const FEATURED_ITEM = 'featured_item';
    const NON_SALEABLE_ON_WEB = 'non_saleable_on_web';
    const WEIGHT = 'weight';
    const IMAGE_NAMES = 'image_names';
    const VAT_CODE = 'vat_code';
    const SELL_PRICE_VAT_VALUE = 'sell_price_vat_value';
    const SEARCH_REF_1 = 'search_ref_1';
    const SEARCH_REF_2 = 'search_ref_2';
    const FREE_STOCK_QUANTITY = 'free_stock_quantity';
    const COMPONENT_ONLY = 'component_only';
    const META_TITLE = 'meta_title';
    const META_KEYWORDS = 'meta_keywords';
    const DISCOUNT_CODE = 'discount_code';
    const CUSTOM_TEXT_1 = 'custom_text_1';
    const CUSTOM_TEXT_2 = 'custom_text_2';
    const CUSTOM_TEXT_3 = 'custom_text_3';
    const CUSTOM_DATE_1 = 'custom_date_1';
    const CUSTOM_DATE_2 = 'custom_date_2';
    const ANALYSIS_CODE = 'analysis_code';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord');
    }

	/**
	 * @return int
	 */
	public function getStockId()
	{
	    return $this->getData(self::STOCK_ID);
	}
	
    /**
     * @param int $stockId
     */
	public function setStockId($stockId)
	{
	    $this->setData(self::STOCK_ID, (int)$stockId);
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
	 * @return string
	 */
	public function getCategoryCodes()
	{
	    return $this->getData(self::CATEGORY_CODES);
	}
	
    /**
     * @param string $categoryCodes
     */
	public function setCategoryCodes($categoryCodes)
	{
	    $this->setData(self::CATEGORY_CODES, (string)$categoryCodes);
	}

	/**
	 * @return float
	 */
	public function getSellPrice()
	{
	    return $this->getData(self::SELL_PRICE);
	}
	
    /**
     * @param float $sellPrice
     */
	public function setSellPrice($sellPrice)
	{
	    $this->setData(self::SELL_PRICE, (float)$sellPrice);
	}

	/**
	 * @return float
	 */
	public function getSellPriceA()
	{
	    return $this->getData(self::SELL_PRICE_A);
	}
	
    /**
     * @param float $sellPriceA
     */
	public function setSellPriceA($sellPriceA)
	{
	    $this->setData(self::SELL_PRICE_A, (float)$sellPriceA);
	}

	/**
	 * @return float
	 */
	public function getSellPriceB()
	{
	    return $this->getData(self::SELL_PRICE_B);
	}
	
    /**
     * @param float $sellPriceB
     */
	public function setSellPriceB($sellPriceB)
	{
	    $this->setData(self::SELL_PRICE_B, (float)$sellPriceB);
	}

	/**
	 * @return float
	 */
	public function getSellPriceC()
	{
	    return $this->getData(self::SELL_PRICE_C);
	}
	
    /**
     * @param float $sellPriceC
     */
	public function setSellPriceC($sellPriceC)
	{
	    $this->setData(self::SELL_PRICE_C, (float)$sellPriceC);
	}

	/**
	 * @return float
	 */
	public function getSellPriceD()
	{
	    return $this->getData(self::SELL_PRICE_D);
	}
	
    /**
     * @param float $sellPriceD
     */
	public function setSellPriceD($sellPriceD)
	{
	    $this->setData(self::SELL_PRICE_D, (float)$sellPriceD);
	}

	/**
	 * @return float
	 */
	public function getSellPriceE()
	{
	    return $this->getData(self::SELL_PRICE_E);
	}
	
    /**
     * @param float $sellPriceE
     */
	public function setSellPriceE($sellPriceE)
	{
	    $this->setData(self::SELL_PRICE_E, (float)$sellPriceE);
	}

	/**
	 * @return float
	 */
	public function getSellPriceF()
	{
	    return $this->getData(self::SELL_PRICE_F);
	}
	
    /**
     * @param float $sellPriceF
     */
	public function setSellPriceF($sellPriceF)
	{
	    $this->setData(self::SELL_PRICE_F, (float)$sellPriceF);
	}

	/**
	 * @return float
	 */
	public function getSellPriceG()
	{
	    return $this->getData(self::SELL_PRICE_G);
	}
	
    /**
     * @param float $sellPriceG
     */
	public function setSellPriceG($sellPriceG)
	{
	    $this->setData(self::SELL_PRICE_G, (float)$sellPriceG);
	}

	/**
	 * @return float
	 */
	public function getSellPriceH()
	{
	    return $this->getData(self::SELL_PRICE_H);
	}
	
    /**
     * @param float $sellPriceH
     */
	public function setSellPriceH($sellPriceH)
	{
	    $this->setData(self::SELL_PRICE_H, (float)$sellPriceH);
	}

	/**
	 * @return float
	 */
	public function getCostPrice()
	{
	    return $this->getData(self::COST_PRICE);
	}
	
    /**
     * @param float $costPrice
     */
	public function setCostPrice($costPrice)
	{
	    $this->setData(self::COST_PRICE, (float)$costPrice);
	}

	/**
	 * @return string
	 */
	public function getUnitDescription()
	{
	    return $this->getData(self::UNIT_DESCRIPTION);
	}
	
    /**
     * @param string $unitDescription
     */
	public function setUnitDescription($unitDescription)
	{
	    $this->setData(self::UNIT_DESCRIPTION, (string)$unitDescription);
	}

	/**
	 * @return string
	 */
	public function getExtendedDescription()
	{
	    return $this->getData(self::EXTENDED_DESCRIPTION);
	}
	
    /**
     * @param string $extendedDescription
     */
	public function setExtendedDescription($extendedDescription)
	{
	    $this->setData(self::EXTENDED_DESCRIPTION, (string)$extendedDescription);
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
	 * @return boolean
	 */
	public function getFeaturedItem()
	{
	    return $this->getData(self::FEATURED_ITEM);
	}
	
    /**
     * @param boolean $featuredItem
     */
	public function setFeaturedItem($featuredItem)
	{
	    $this->setData(self::FEATURED_ITEM, (boolean)$featuredItem);
	}

	/**
	 * @return boolean
	 */
	public function getNonSaleableOnWeb()
	{
	    return $this->getData(self::NON_SALEABLE_ON_WEB);
	}
	
    /**
     * @param boolean $nonSaleableOnWeb
     */
	public function setNonSaleableOnWeb($nonSaleableOnWeb)
	{
	    $this->setData(self::NON_SALEABLE_ON_WEB, (boolean)$nonSaleableOnWeb);
	}

	/**
	 * @return float
	 */
	public function getWeight()
	{
	    return $this->getData(self::WEIGHT);
	}
	
    /**
     * @param float $weight
     */
	public function setWeight($weight)
	{
	    $this->setData(self::WEIGHT, (float)$weight);
	}

	/**
	 * @return string
	 */
	public function getImageNames()
	{
	    return $this->getData(self::IMAGE_NAMES);
	}
	
    /**
     * @param string $imageNames
     */
	public function setImageNames($imageNames)
	{
	    $this->setData(self::IMAGE_NAMES, (string)$imageNames);
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
	public function getSellPriceVatValue()
	{
	    return $this->getData(self::SELL_PRICE_VAT_VALUE);
	}
	
    /**
     * @param float $sellPriceVatValue
     */
	public function setSellPriceVatValue($sellPriceVatValue)
	{
	    $this->setData(self::SELL_PRICE_VAT_VALUE, (float)$sellPriceVatValue);
	}

	/**
	 * @return string
	 */
	public function getSearchRef1()
	{
	    return $this->getData(self::SEARCH_REF_1);
	}
	
    /**
     * @param string $searchRef1
     */
	public function setSearchRef1($searchRef1)
	{
	    $this->setData(self::SEARCH_REF_1, (string)$searchRef1);
	}

	/**
	 * @return string
	 */
	public function getSearchRef2()
	{
	    return $this->getData(self::SEARCH_REF_2);
	}
	
    /**
     * @param string $searchRef2
     */
	public function setSearchRef2($searchRef2)
	{
	    $this->setData(self::SEARCH_REF_2, (string)$searchRef2);
	}

	/**
	 * @return float
	 */
	public function getFreeStockQuantity()
	{
	    return $this->getData(self::FREE_STOCK_QUANTITY);
	}
	
    /**
     * @param float $freeStockQuantity
     */
	public function setFreeStockQuantity($freeStockQuantity)
	{
	    $this->setData(self::FREE_STOCK_QUANTITY, (float)$freeStockQuantity);
	}

	/**
	 * @return boolean
	 */
	public function getComponentOnly()
	{
	    return $this->getData(self::COMPONENT_ONLY);
	}
	
    /**
     * @param boolean $componentOnly
     */
	public function setComponentOnly($componentOnly)
	{
	    $this->setData(self::COMPONENT_ONLY, (boolean)$componentOnly);
	}

	/**
	 * @return string
	 */
	public function getMetaTitle()
	{
	    return $this->getData(self::META_TITLE);
	}
	
    /**
     * @param string $metaTitle
     */
	public function setMetaTitle($metaTitle)
	{
	    $this->setData(self::META_TITLE, (string)$metaTitle);
	}

	/**
	 * @return string
	 */
	public function getMetaKeywords()
	{
	    return $this->getData(self::META_KEYWORDS);
	}
	
    /**
     * @param string $metaKeywords
     */
	public function setMetaKeywords($metaKeywords)
	{
	    $this->setData(self::META_KEYWORDS, (string)$metaKeywords);
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
	public function getAnalysisCode()
	{
	    return $this->getData(self::ANALYSIS_CODE);
	}
	
    /**
     * @param string $analysisCode
     */
	public function setAnalysisCode($analysisCode)
	{
	    $this->setData(self::ANALYSIS_CODE, (string)$analysisCode);
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
