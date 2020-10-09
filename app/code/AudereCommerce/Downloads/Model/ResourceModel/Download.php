<?php

namespace AudereCommerce\Downloads\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Download extends AbstractDb
{

    public function _construct()
    {
        $this->_init('auderecommerce_downloads_download', 'id');
    }
}