<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\CustomerRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $_customerCollectionFactory = null;
    /* @var $_customerCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $customerCollectionFactory)
    {
        $this->_customerCollectionFactory = $customerCollectionFactory;
    }

    /**
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function save(CustomerInterface $customer)
    {
        $customer->getResource()->save($customer);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        $customerCollection = $this->_customerCollectionFactory->create();
        /* @var $customerCollection Collection */

        if ($searchCriteria) {
            $filterGroups = $searchCriteria->getFilterGroups();

            foreach ($filterGroups as $filterGroup) {
                /* @var $filterGroup FilterGroup */
                foreach ($filterGroup->getFilters() as $filter) {
                    /* @var $filter Filter */
                    $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    $customerCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
                }
            }
        }

        return $customerCollection;
    }
}
