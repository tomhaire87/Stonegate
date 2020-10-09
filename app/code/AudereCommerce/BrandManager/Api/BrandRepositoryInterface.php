<?php

namespace AudereCommerce\BrandManager\Api;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\BrandManager\Api\Data\BrandInterface;
use AudereCommerce\BrandManager\Api\Data\BrandSearchResultsInterface;

interface BrandRepositoryInterface
{

    /**
     * @param BrandInterface $brand
     * @return BrandInterface
     */
    public function save(BrandInterface $brand);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return BrandInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return BrandSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param BrandInterface $brand
     * @return bool
     */
    public function delete(BrandInterface $brand);
}