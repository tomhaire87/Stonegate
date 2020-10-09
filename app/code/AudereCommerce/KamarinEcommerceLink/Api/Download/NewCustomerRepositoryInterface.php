<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface NewCustomerRepositoryInterface
{
    /**
     * @param NewCustomerInterface $newCustomer
     * @return NewCustomerInterface
     */
    public function save(NewCustomerInterface $newCustomer);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return NewCustomerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
