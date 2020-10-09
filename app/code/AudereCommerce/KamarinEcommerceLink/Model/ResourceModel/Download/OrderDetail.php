<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderDetail extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('order_details', 'order_details_id');
    }
}
