<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateInterface;
use Magento\Framework\Model\AbstractModel;

class VatRate extends AbstractModel implements VatRateInterface
{
    const VAT_RATE_ID = 'vat_rate_id';
    const CODE = 'code';
    const DESCRIPTION = 'description';
    const RATE = 'rate';
    const RECORD_UPDATED = 'record_updated';

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate');
    }

	/**
	 * @return int
	 */
	public function getVatRateId()
	{
	    return $this->getData(self::VAT_RATE_ID);
	}
	
    /**
     * @param int $vatRateId
     */
	public function setVatRateId($vatRateId)
	{
	    $this->setData(self::VAT_RATE_ID, (int)$vatRateId);
	}

	/**
	 * @return string
	 */
	public function getCode()
	{
	    return $this->getData(self::CODE);
	}
	
    /**
     * @param string $code
     */
	public function setCode($code)
	{
	    $this->setData(self::CODE, (string)$code);
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
	public function getRate()
	{
	    return $this->getData(self::RATE);
	}
	
    /**
     * @param float $rate
     */
	public function setRate($rate)
	{
	    $this->setData(self::RATE, (float)$rate);
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
