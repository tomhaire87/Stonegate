<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class QuantityBreakSpecialPrice extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('quantity_break_special_prices', 'qty_break_price_id');
    }
}
