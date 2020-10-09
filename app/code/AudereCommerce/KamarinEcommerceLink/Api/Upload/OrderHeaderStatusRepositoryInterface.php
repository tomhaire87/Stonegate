<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderHeaderStatusRepositoryInterface
{
    /**
     * @param OrderHeaderStatusInterface $orderHeaderStatus
     * @return OrderHeaderStatusInterface
     */
    public function save(OrderHeaderStatusInterface $orderHeaderStatus);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderHeaderStatusSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
