<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderHeaderRepositoryInterface
{
    /**
     * @param OrderHeaderInterface $orderHeader
     * @return OrderHeaderInterface
     */
    public function save(OrderHeaderInterface $orderHeader);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderHeaderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param $orderNumber
     * @return OrderHeaderInterface
     */
    public function getByOrderNumber($orderNumber);
}
