<?php

namespace AudereCommerce\Downloads\Api;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\Downloads\Api\Data\DownloadInterface;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;

interface DownloadRepositoryInterface
{

    /**
     * @param DownloadInterface $download
     * @return DownloadInterface
     */
    public function save(DownloadInterface $download);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return DownloadInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return DownloadSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param DownloadInterface $download
     * @return bool
     */
    public function delete(DownloadInterface $download);
}