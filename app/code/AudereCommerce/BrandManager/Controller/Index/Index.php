<?php

namespace AudereCommerce\BrandManager\Controller\Index;

use Magento\Framework\App\Action\Action;

class Index extends Action
{

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

}
