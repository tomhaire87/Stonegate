<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerSpecialPrice extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_special_prices', 'special_price_id');
    }
}
