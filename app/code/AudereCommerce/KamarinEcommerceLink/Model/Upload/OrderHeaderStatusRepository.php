<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\OrderHeaderStatusRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class OrderHeaderStatusRepository implements OrderHeaderStatusRepositoryInterface
{
    protected $_orderHeaderStatusCollectionFactory = null;
    /* @var $_orderHeaderStatusCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $orderHeaderStatusCollectionFactory)
    {
        $this->_orderHeaderStatusCollectionFactory = $orderHeaderStatusCollectionFactory;
    }

    /**
     * @param OrderHeaderStatusInterface $orderHeaderStatus
     * @return OrderHeaderStatusInterface
     */
    public function save(OrderHeaderStatusInterface $orderHeaderStatus)
    {
        $orderHeaderStatus->getResource()->save($orderHeaderStatus);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderHeaderStatusSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $orderHeaderStatusCollection = $this->_orderHeaderStatusCollectionFactory->create();
        /* @var $orderHeaderStatusCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $orderHeaderStatusCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $orderHeaderStatusCollection; 
    }
}
