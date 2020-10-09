<?php

namespace AudereCommerce\BrandManager\Model;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\BrandManager\Api\BrandRepositoryInterface;
use AudereCommerce\BrandManager\Api\Data\BrandInterface;
use AudereCommerce\BrandManager\Api\Data\BrandSearchResultsInterface;
use AudereCommerce\BrandManager\Model\BrandFactory;
use AudereCommerce\BrandManager\Model\ResourceModel\Brand\CollectionFactory;

class BrandRepository implements BrandRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_brandCollectionFactory;

    /**
     * @var BrandFactory
     */
    protected $_brandFactory;

    /**
     * @var BrandInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $brandCollectionFactory
     * @param BrandFactory $brandFactory
     */
    public function __construct(CollectionFactory $brandCollectionFactory, BrandFactory $brandFactory)
    {
        $this->_brandCollectionFactory = $brandCollectionFactory;
        $this->_brandFactory = $brandFactory;
    }

    /**
     * @param BrandInterface $brand
     * @return BrandInterface
     */
    public function save(BrandInterface $brand)
    {
        return $brand->getResource()->save($brand);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return BrandInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_brandFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('id', $id);
            }

            $this->_instancesById[$id] = $model;
        }

        return $this->_instancesById[$id];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return BrandSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $brandCollection = $this->_brandCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $brandCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $brandCollection;
    }

    /**
     * @param BrandInterface $brand
     * @return bool
     */
    public function delete(BrandInterface $brand)
    {
        $id = $brand->getId();

        try {
            unset($this->_instancesById[$id]);
            $brand->getResource()->delete($brand);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to remove %1', $id));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        $model = $this->getById($id);
        return $this->delete($model);
    }
}