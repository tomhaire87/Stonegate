<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\AccountsIntegration\Api\Data\AccountInterface;
use AudereCommerce\AccountsIntegration\Api\Data\AccountSearchResultsInterface;

interface AccountRepositoryInterface
{

    /**
     * @param AccountInterface $account
     * @return AccountInterface
     */
    public function save(AccountInterface $account);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return AccountInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param string $code
     * @param bool $forceReload
     * @return AccountInterface
     */
    public function getByCode($code, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return AccountSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param AccountInterface $account
     * @return bool
     */
    public function delete(AccountInterface $account);

}