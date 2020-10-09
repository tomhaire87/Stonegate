<?php

namespace AudereCommerce\SlideManager\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slide extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('auderecommerce_slidemanager_slide', 'slide_id');
    }

}