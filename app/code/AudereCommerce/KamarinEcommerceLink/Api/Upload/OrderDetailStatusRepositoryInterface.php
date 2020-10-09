<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderDetailStatusRepositoryInterface
{
    /**
     * @param OrderDetailStatusInterface $orderDetailStatus
     * @return OrderDetailStatusInterface
     */
    public function save(OrderDetailStatusInterface $orderDetailStatus);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderDetailStatusSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
