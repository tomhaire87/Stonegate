<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Download;

use AudereCommerce\KamarinEcommerceLink\Api\Download\NewCustomerRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class NewCustomerRepository implements NewCustomerRepositoryInterface
{
    protected $_newCustomerCollectionFactory = null;
    /* @var $_newCustomerCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $newCustomerCollectionFactory)
    {
        $this->_newCustomerCollectionFactory = $newCustomerCollectionFactory;
    }

    /**
     * @param NewCustomerInterface $newCustomer
     * @return NewCustomerInterface
     */
    public function save(NewCustomerInterface $newCustomer)
    {
        $newCustomer->getResource()->save($newCustomer);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return NewCustomerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $newCustomerCollection = $this->_newCustomerCollectionFactory->create();
        /* @var $newCustomerCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $newCustomerCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $newCustomerCollection; 
    }
}
