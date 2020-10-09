<?php

namespace AudereCommerce\Downloads\Model\Download;

use \Magento\Framework\Api\SearchCriteriaBuilder;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Api\Download\GroupManagementInterface;
use AudereCommerce\Downloads\Model\Download\Group;
use AudereCommerce\Downloads\Model\DownloadRepository;

class GroupManagement implements GroupManagementInterface
{

    /**
     * @var DownloadRepository
     */
    protected $_downloadRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param DownloadRepository $downloadRepository
     */
    public function __construct(SearchCriteriaBuilder $searchCriteriaBuilder, DownloadRepository $downloadRepository)
    {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_downloadRepository = $downloadRepository;
    }

    /**
     * @param Group $model
     * @return DownloadSearchResultsInterface
     */
    public function getDownloads(Group $model)
    {
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('group_id', $model->getData('id'), 'in')
            ->create();

        return $this->_downloadRepository->getList($searchCriteria);
    }
}