<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

class Grid extends Slide
{

    public function execute()
    {
        return $this->_resultPageFactory->create();
    }

}