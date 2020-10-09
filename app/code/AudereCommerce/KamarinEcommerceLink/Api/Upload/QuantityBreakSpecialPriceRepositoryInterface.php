<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface QuantityBreakSpecialPriceRepositoryInterface
{
    /**
     * @param QuantityBreakSpecialPriceInterface $quantityBreakSpecialPrice
     * @return QuantityBreakSpecialPriceInterface
     */
    public function save(QuantityBreakSpecialPriceInterface $quantityBreakSpecialPrice);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuantityBreakSpecialPriceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
