<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class NewCustomer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('new_customers', 'customer_id');
    }
}
