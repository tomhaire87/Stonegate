<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface OrderDetailRepositoryInterface
{
    /**
     * @param OrderDetailInterface $orderDetail
     * @return OrderDetailInterface
     */
    public function save(OrderDetailInterface $orderDetail);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderDetailSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param $itemId
     * @return OrderDetailInterface
     */
    public function getByItemId($itemId);
}
