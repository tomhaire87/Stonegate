<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Account extends AbstractDb
{

    public function _construct()
    {
        $this->_init('auderecommerce_accountsintegration_account', 'id');
    }
}