<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomerSpecialPriceRepositoryInterface
{
    /**
     * @param CustomerSpecialPriceInterface $customerSpecialPrice
     * @return CustomerSpecialPriceInterface
     */
    public function save(CustomerSpecialPriceInterface $customerSpecialPrice);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomerSpecialPriceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
