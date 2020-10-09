<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\ResourceModel\Account;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\AccountsIntegration\Api\Data\AccountSearchResultsInterface;

class Collection extends AbstractCollection implements AccountSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\AccountsIntegration\Model\Account', 'AudereCommerce\AccountsIntegration\Model\ResourceModel\Account');
    }
}