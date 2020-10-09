<?php

namespace AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

use AudereCommerce\SlideManager\Controller\Adminhtml\Slide;

class Index extends Slide
{

    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            return $this->_forward('grid');
        }

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Slide'));

        return $resultPage;
    }

}