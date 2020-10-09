<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface StockQuantitiesRepositoryInterface
{
    /**
     * @param StockQuantitiesInterface $stockQuantities
     * @return StockQuantitiesInterface
     */
    public function save(StockQuantitiesInterface $stockQuantities);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StockQuantitiesSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param $stockCode
     * @return StockQuantitiesInterface
     * @throws NoSuchEntityException
     */
    public function getByStockCode($stockCode);
}
