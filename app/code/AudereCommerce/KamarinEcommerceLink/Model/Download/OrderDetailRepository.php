<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Download\OrderDetailRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    protected $_orderDetailCollectionFactory = null;
    /* @var $_orderDetailCollectionFactory CollectionFactory */
    protected $_searchCriteriaBuilder = null;
    /* @var $_searchCriteriaBuilder SearchCriteriaBuilder */

    public function __construct(
        CollectionFactory $orderDetailCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_orderDetailCollectionFactory = $orderDetailCollectionFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param OrderDetailInterface $orderDetail
     * @return OrderDetailInterface
     */
    public function save(OrderDetailInterface $orderDetail)
    {
        $orderDetail->getResource()->save($orderDetail);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return OrderDetailSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $orderDetailCollection = $this->_orderDetailCollectionFactory->create();
        /* @var $orderDetailCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $orderDetailCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $orderDetailCollection; 
    }

    /**
     * @param $itemId
     * @return OrderDetailInterface
     */
    public function getByItemId($itemId)
    {
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('original_web_order_line_id', $itemId)->create();
        $orderDetails = $this->getList($searchCriteria);
        return $orderDetails->getFirstItem();
    }
}
