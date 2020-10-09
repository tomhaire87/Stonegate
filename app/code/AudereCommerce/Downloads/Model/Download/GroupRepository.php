<?php

namespace AudereCommerce\Downloads\Model\Download;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use AudereCommerce\Downloads\Api\Data\Download\GroupSearchResultsInterface;
use AudereCommerce\Downloads\Api\Download\GroupRepositoryInterface;
use AudereCommerce\Downloads\Model\Download\GroupFactory;
use AudereCommerce\Downloads\Model\ResourceModel\Download\Group\CollectionFactory;

class GroupRepository implements GroupRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_downloadGroupCollectionFactory;

    /**
     * @var GroupFactory
     */
    protected $_downloadGroupFactory;

    /**
     * @var GroupInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $downloadGroupCollectionFactory
     * @param GroupFactory $downloadGroupFactory
     */
    public function __construct(CollectionFactory $downloadGroupCollectionFactory, GroupFactory $downloadGroupFactory)
    {
        $this->_downloadGroupCollectionFactory = $downloadGroupCollectionFactory;
        $this->_downloadGroupFactory = $downloadGroupFactory;
    }

    /**
     * @param GroupInterface $downloadGroup
     * @return GroupInterface
     */
    public function save(GroupInterface $downloadGroup)
    {
        return $downloadGroup->getResource()->save($downloadGroup);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return GroupInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_downloadGroupFactory->create();
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
     * @return GroupSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $downloadGroupCollection = $this->_downloadGroupCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $downloadGroupCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $downloadGroupCollection;
    }

    /**
     * @param GroupInterface $downloadGroup
     * @return bool
     */
    public function delete(GroupInterface $downloadGroup)
    {
        $id = $downloadGroup->getId();

        try {
            unset($this->_instancesById[$id]);
            $downloadGroup->getResource()->delete($downloadGroup);
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