<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class NewAction extends Slider
{

    public function execute()
    {
        return $this->_forward('edit');
    }

}