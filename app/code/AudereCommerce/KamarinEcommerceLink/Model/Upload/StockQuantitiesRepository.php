<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockQuantitiesRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class StockQuantitiesRepository implements StockQuantitiesRepositoryInterface
{
    protected $_stockQuantitiesCollectionFactory = null;
    /* @var $_stockQuantitiesCollectionFactory CollectionFactory */
    protected $_searchCriteriaBuilder = null;

    /* @var $_searchCriteriaBuilder SearchCriteriaBuilder */

    public function __construct(
        CollectionFactory $stockQuantitiesCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_stockQuantitiesCollectionFactory = $stockQuantitiesCollectionFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param StockQuantitiesInterface $stockQuantities
     * @return StockQuantitiesInterface
     */
    public function save(StockQuantitiesInterface $stockQuantities)
    {
        $stockQuantities->getResource()->save($stockQuantities);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StockQuantitiesSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $stockQuantitiesCollection = $this->_stockQuantitiesCollectionFactory->create();
        /* @var $stockQuantitiesCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $stockQuantitiesCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $stockQuantitiesCollection;
    }

    /**
     * @param string $stockCode
     * @return StockQuantitiesInterface
     * @throws NoSuchEntityException
     */
    public function getByStockCode($stockCode)
    {
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('stock_code', $stockCode)->create();
        $stockQuantities = $this->getList($searchCriteria)->getFirstItem();

        if ($stockQuantities->getId()) {
            return $stockQuantities;
        } else {
            throw new NoSuchEntityException();
        }
    }
}
