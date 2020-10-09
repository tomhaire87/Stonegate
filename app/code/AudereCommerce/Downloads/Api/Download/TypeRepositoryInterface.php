<?php

namespace AudereCommerce\Downloads\Api\Download;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use AudereCommerce\Downloads\Api\Data\Download\TypeSearchResultsInterface;

interface TypeRepositoryInterface
{

    /**
     * @param TypeInterface $downloadType
     * @return TypeInterface
     */
    public function save(TypeInterface $downloadType);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return TypeInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TypeSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param TypeInterface $downloadType
     * @return bool
     */
    public function delete(TypeInterface $downloadType);
}