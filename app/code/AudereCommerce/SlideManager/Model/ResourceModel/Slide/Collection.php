<?php

namespace AudereCommerce\SlideManager\Model\ResourceModel\Slide;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init('AudereCommerce\SlideManager\Model\Slide', 'AudereCommerce\SlideManager\Model\ResourceModel\Slide');
    }

}