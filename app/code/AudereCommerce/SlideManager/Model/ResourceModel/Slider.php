<?php

namespace AudereCommerce\SlideManager\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slider extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('auderecommerce_slidemanager_slider', 'slider_id');
    }

}