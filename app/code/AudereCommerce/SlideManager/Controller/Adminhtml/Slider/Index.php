<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slider;

class Index extends Slider
{

    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            return $this->_forward('grid');
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Sliders'));

        return $resultPage;
    }

}