<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\VatRateRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class VatRateRepository implements VatRateRepositoryInterface
{
    protected $_vatRateCollectionFactory = null;
    /* @var $_vatRateCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $vatRateCollectionFactory)
    {
        $this->_vatRateCollectionFactory = $vatRateCollectionFactory;
    }

    /**
     * @param VatRateInterface $vatRate
     * @return VatRateInterface
     */
    public function save(VatRateInterface $vatRate)
    {
        $vatRate->getResource()->save($vatRate);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VatRateSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $vatRateCollection = $this->_vatRateCollectionFactory->create();
        /* @var $vatRateCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $vatRateCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $vatRateCollection; 
    }
}
