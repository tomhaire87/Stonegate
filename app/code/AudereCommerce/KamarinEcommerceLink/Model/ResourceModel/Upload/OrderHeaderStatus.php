<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderHeaderStatus extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('order_headers_statuses', 'order_headers_statuses_id');
    }
}
