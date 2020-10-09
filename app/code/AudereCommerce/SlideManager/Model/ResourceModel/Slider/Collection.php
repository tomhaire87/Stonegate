<?php

namespace AudereCommerce\SlideManager\Model\ResourceModel\Slider;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init('AudereCommerce\SlideManager\Model\Slider', 'AudereCommerce\SlideManager\Model\ResourceModel\Slider');
    }

}