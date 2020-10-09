<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class OrderDetailStatus extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('order_details_statuses', 'order_details_statuses_id');
    }
}
