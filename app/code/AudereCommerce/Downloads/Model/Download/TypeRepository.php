<?php

namespace AudereCommerce\Downloads\Model\Download;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use AudereCommerce\Downloads\Api\Data\Download\TypeSearchResultsInterface;
use AudereCommerce\Downloads\Api\Download\TypeRepositoryInterface;
use AudereCommerce\Downloads\Model\Download\TypeFactory;
use AudereCommerce\Downloads\Model\ResourceModel\Download\Type\CollectionFactory;

class TypeRepository implements TypeRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_downloadTypeCollectionFactory;

    /**
     * @var TypeFactory
     */
    protected $_downloadTypeFactory;

    /**
     * @var TypeInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $downloadTypeCollectionFactory
     * @param TypeFactory $downloadTypeFactory
     */
    public function __construct(CollectionFactory $downloadTypeCollectionFactory, TypeFactory $downloadTypeFactory)
    {
        $this->_downloadTypeCollectionFactory = $downloadTypeCollectionFactory;
        $this->_downloadTypeFactory = $downloadTypeFactory;
    }

    /**
     * @param TypeInterface $downloadType
     * @return TypeInterface
     */
    public function save(TypeInterface $downloadType)
    {
        return $downloadType->getResource()->save($downloadType);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return TypeInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_downloadTypeFactory->create();
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
     * @return TypeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $downloadTypeCollection = $this->_downloadTypeCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $downloadTypeCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $downloadTypeCollection;
    }

    /**
     * @param TypeInterface $downloadType
     * @return bool
     */
    public function delete(TypeInterface $downloadType)
    {
        $id = $downloadType->getId();

        try {
            unset($this->_instancesById[$id]);
            $downloadType->getResource()->delete($downloadType);
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