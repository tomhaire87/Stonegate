<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

class NewAction extends Slide
{

    public function execute()
    {
        return $this->_forward('edit');
    }

}