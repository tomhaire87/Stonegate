<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class Grid extends Slider
{

    public function execute()
    {
        return $this->_resultPageFactory->create();
    }

}