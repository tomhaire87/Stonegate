<?php

namespace AudereCommerce\BrandManager\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Brand extends AbstractDb
{

    public function _construct()
    {
        $this->_init('auderecommerce_brandmanager_brand', 'id');
    }
}