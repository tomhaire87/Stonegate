<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Download\OrderHeaderRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class OrderHeaderRepository implements OrderHeaderRepositoryInterface
{
    protected $_orderHeaderCollectionFactory = null;
    /* @var $_orderHeaderCollectionFactory CollectionFactory */
    protected $_searchCriteriaBuilder = null;
    /* @var $_searchCriteriaBuilder SearchCriteriaBuilder */

    public function __construct(
        CollectionFactory $orderHeaderCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_orderHeaderCollectionFactory = $orderHeaderCollectionFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param OrderHeaderInterface $orderHeader
     * @return OrderHeaderInterface
     */
    public function save(OrderHeaderInterface $orderHeader)
    {
        $orderHeader->getResource()->save($orderHeader);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderHeaderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $orderHeaderCollection = $this->_orderHeaderCollectionFactory->create();
        /* @var $orderHeaderCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $orderHeaderCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $orderHeaderCollection; 
    }

    public function getByOrderNumber($orderNumber)
    {
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('order_number', $orderNumber)->create();
        $orderHeaders = $this->getList($searchCriteria);
        return $orderHeaders->getFirstItem();
    }
}
