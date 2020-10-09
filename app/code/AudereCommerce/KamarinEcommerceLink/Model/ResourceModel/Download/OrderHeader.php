<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderHeader extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('order_headers', 'order_header_id');
    }
}
