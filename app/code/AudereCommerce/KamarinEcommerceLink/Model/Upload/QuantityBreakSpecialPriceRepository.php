<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\QuantityBreakSpecialPriceRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;

class QuantityBreakSpecialPriceRepository implements QuantityBreakSpecialPriceRepositoryInterface
{
    protected $_quantityBreakSpecialPriceCollectionFactory = null;
    /* @var $_quantityBreakSpecialPriceCollectionFactory CollectionFactory */ 

    public function __construct(CollectionFactory $quantityBreakSpecialPriceCollectionFactory)
    {
        $this->_quantityBreakSpecialPriceCollectionFactory = $quantityBreakSpecialPriceCollectionFactory;
    }

    /**
     * @param QuantityBreakSpecialPriceInterface $quantityBreakSpecialPrice
     * @return QuantityBreakSpecialPriceInterface
     */
    public function save(QuantityBreakSpecialPriceInterface $quantityBreakSpecialPrice)
    {
        $quantityBreakSpecialPrice->getResource()->save($quantityBreakSpecialPrice);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuantityBreakSpecialPriceSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $quantityBreakSpecialPriceCollection = $this->_quantityBreakSpecialPriceCollectionFactory->create();
        /* @var $quantityBreakSpecialPriceCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $quantityBreakSpecialPriceCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $quantityBreakSpecialPriceCollection; 
    }
}
