<?php

namespace AudereCommerce\SlideManager\Model;

use \Magento\Framework\Model\AbstractModel;

class Slide extends AbstractModel
{

    protected function _construct()
    {
        $this->_init('AudereCommerce\SlideManager\Model\ResourceModel\Slide');
    }

}