<?php

namespace AudereCommerce\Downloads\Model\Download;

use \Magento\Framework\Api\SearchCriteriaBuilder;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Api\Download\TypeManagementInterface;
use AudereCommerce\Downloads\Model\Download\Type;
use AudereCommerce\Downloads\Model\DownloadRepository;

class TypeManagement implements TypeManagementInterface
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
     * @param Type $model
     * @return DownloadSearchResultsInterface
     */
    public function getDownloads(Type $model)
    {
        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('type_id', $model->getData('id'), 'in')
            ->create();

        return $this->_downloadRepository->getList($searchCriteria);
    }
}