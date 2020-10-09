<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Api;

use AudereCommerce\AccountsIntegration\Model\Account;

interface AccountManagementInterface
{

    /**
     * @param Account $model
     * @return \Magento\Customer\Api\Data\GroupInterface
     */
    public function getCustomerGroup(Account $model);

}