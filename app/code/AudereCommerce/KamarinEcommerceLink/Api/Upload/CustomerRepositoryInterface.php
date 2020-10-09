<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomerRepositoryInterface
{
    /**
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function save(CustomerInterface $customer);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);
}
