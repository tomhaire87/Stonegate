<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

use AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

class NewAction extends Brand
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}