<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\CustomerSpecialPriceRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class CustomerSpecialPriceRepository implements CustomerSpecialPriceRepositoryInterface
{
    protected $_customerSpecialPriceCollectionFactory = null;
    /* @var $_customerSpecialPriceCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $customerSpecialPriceCollectionFactory)
    {
        $this->_customerSpecialPriceCollectionFactory = $customerSpecialPriceCollectionFactory;
    }

    /**
     * @param CustomerSpecialPriceInterface $customerSpecialPrice
     * @return CustomerSpecialPriceInterface
     */
    public function save(CustomerSpecialPriceInterface $customerSpecialPrice)
    {
        $customerSpecialPrice->getResource()->save($customerSpecialPrice);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomerSpecialPriceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        $customerSpecialPriceCollection = $this->_customerSpecialPriceCollectionFactory->create();
        /* @var $customerSpecialPriceCollection Collection */

        if ($searchCriteria) {
            $filterGroups = $searchCriteria->getFilterGroups();

            foreach ($filterGroups as $filterGroup) {
                /* @var $filterGroup FilterGroup */
                foreach ($filterGroup->getFilters() as $filter) {
                    /* @var $filter Filter */
                    $customerSpecialPriceCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
                }
            }
        }

        return $customerSpecialPriceCollection; 
    }
}
