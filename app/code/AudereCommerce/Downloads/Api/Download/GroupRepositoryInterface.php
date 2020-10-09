<?php

namespace AudereCommerce\Downloads\Api\Download;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use AudereCommerce\Downloads\Api\Data\Download\GroupSearchResultsInterface;

interface GroupRepositoryInterface
{

    /**
     * @param GroupInterface $downloadGroup
     * @return GroupInterface
     */
    public function save(GroupInterface $downloadGroup);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return GroupInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return GroupSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param GroupInterface $downloadGroup
     * @return bool
     */
    public function delete(GroupInterface $downloadGroup);
}