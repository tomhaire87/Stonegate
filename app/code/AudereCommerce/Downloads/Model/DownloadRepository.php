<?php

namespace AudereCommerce\Downloads\Model;

use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\Downloads\Api\Data\DownloadInterface;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Api\DownloadRepositoryInterface;
use AudereCommerce\Downloads\Model\DownloadFactory;
use AudereCommerce\Downloads\Model\ResourceModel\Download\CollectionFactory;

class DownloadRepository implements DownloadRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_downloadCollectionFactory;

    /**
     * @var DownloadFactory
     */
    protected $_downloadFactory;

    /**
     * @var DownloadInterface[]
     */
    protected $_instancesById = array();

    /**
     * @param CollectionFactory $downloadCollectionFactory
     * @param DownloadFactory $downloadFactory
     */
    public function __construct(CollectionFactory $downloadCollectionFactory, DownloadFactory $downloadFactory)
    {
        $this->_downloadCollectionFactory = $downloadCollectionFactory;
        $this->_downloadFactory = $downloadFactory;
    }

    /**
     * @param DownloadInterface $download
     * @return DownloadInterface
     */
    public function save(DownloadInterface $download)
    {
        return $download->getResource()->save($download);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return DownloadInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_downloadFactory->create();
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
     * @return DownloadSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $downloadCollection = $this->_downloadCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $downloadCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $downloadCollection;
    }

    /**
     * @param DownloadInterface $download
     * @return bool
     */
    public function delete(DownloadInterface $download)
    {
        $id = $download->getId();

        try {
            unset($this->_instancesById[$id]);
            $download->getResource()->delete($download);
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