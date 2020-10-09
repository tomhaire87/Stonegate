<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class VatRate extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vat_rates', 'vat_rate_id');
    }
}
