<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface StockRecordRepositoryInterface
{
    /**
     * @param StockRecordInterface $stockRecord
     * @return StockRecordInterface
     */
    public function save(StockRecordInterface $stockRecord);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StockRecordSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param $stockCode
     * @return StockRecordInterface
     * @throws NoSuchEntityException
     */
    public function getByStockCode($stockCode);
}
