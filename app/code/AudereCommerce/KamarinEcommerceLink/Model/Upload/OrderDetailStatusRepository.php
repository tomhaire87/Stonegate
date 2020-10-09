<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\OrderDetailStatusRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class OrderDetailStatusRepository implements OrderDetailStatusRepositoryInterface
{
    protected $_orderDetailStatusCollectionFactory = null;
    /* @var $_orderDetailStatusCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $orderDetailStatusCollectionFactory)
    {
        $this->_orderDetailStatusCollectionFactory = $orderDetailStatusCollectionFactory;
    }

    /**
     * @param OrderDetailStatusInterface $orderDetailStatus
     * @return OrderDetailStatusInterface
     */
    public function save(OrderDetailStatusInterface $orderDetailStatus)
    {
        $orderDetailStatus->getResource()->save($orderDetailStatus);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderDetailStatusSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $orderDetailStatusCollection = $this->_orderDetailStatusCollectionFactory->create();
        /* @var $orderDetailStatusCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $orderDetailStatusCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $orderDetailStatusCollection; 
    }
}
