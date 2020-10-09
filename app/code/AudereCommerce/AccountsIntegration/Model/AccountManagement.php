<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model;

use Magento\Customer\Model\GroupRegistry;
use Magento\Customer\Api\GroupRepositoryInterface;
use AudereCommerce\AccountsIntegration\Api\AccountManagementInterface;
use AudereCommerce\AccountsIntegration\Model\Account;

class AccountManagement implements AccountManagementInterface
{

    /**
     * @var GroupRepositoryInterface
     */
    protected $_groupRepository;

    /**
     * @param GroupRepositoryInterface $groupRepository
     */
    public function __construct(GroupRepositoryInterface $groupRepository)
    {
        $this->_groupRepository = $groupRepository;
    }

    /**
     * @param \AudereCommerce\AccountsIntegration\Model\Account $model
     * @return \Magento\Customer\Api\Data\GroupInterface
     */
    public function getCustomerGroup(Account $model)
    {
        return $this->_groupRepository->getById($model->getCustomerGroupId());
    }
}