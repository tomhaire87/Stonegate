<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Upload\StockRecordRepositoryInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordSearchResultsInterface;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord\Collection;
use AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class StockRecordRepository implements StockRecordRepositoryInterface
{
    protected $_stockRecordCollectionFactory = null;
    /* @var $_stockRecordCollectionFactory CollectionFactory */
    protected $_searchCriteriaBuilder = null;
    /* @var $_searchCriteriaBuilder SearchCriteriaBuilder */

    public function __construct(
        CollectionFactory $stockRecordCollectionFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_stockRecordCollectionFactory = $stockRecordCollectionFactory;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param StockRecordInterface $stockRecord
     * @return StockRecordInterface
     */
    public function save(StockRecordInterface $stockRecord)
    {
        $stockRecord->getResource()->save($stockRecord);
    }
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return StockRecordSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $stockRecordCollection = $this->_stockRecordCollectionFactory->create();
        /* @var $stockRecordCollection Collection */
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            /* @var $filterGroup FilterGroup */
            foreach ($filterGroup->getFilters() as $filter) {
                /* @var $filter Filter */
                $stockRecordCollection->addFilter($filter->getField(), $filter->getValue(), $filter->getConditionType());
            }
        }

        return $stockRecordCollection; 
    }

    /**
     * @param string $stockCode
     * @return StockRecordInterface
     * @throws NoSuchEntityException
     */
    public function getByStockCode($stockCode)
    {
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('stock_code', $stockCode)->create();
        $stockRecord = $this->getList($searchCriteria)->getFirstItem();

        if ($stockRecord->getId()) {
            return $stockRecord;
        } else {
            throw new NoSuchEntityException();
        }
    }
}
