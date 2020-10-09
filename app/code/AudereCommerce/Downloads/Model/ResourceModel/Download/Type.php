<?php

namespace AudereCommerce\Downloads\Model\ResourceModel\Download;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Type extends AbstractDb
{

    public function _construct()
    {
        $this->_init('auderecommerce_downloads_download_type', 'id');
    }
}