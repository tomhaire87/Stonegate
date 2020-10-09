<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

use AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

class Index extends Brand
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_BrandManager::brand')
            ->addBreadcrumb(__('Manage Brand'), __('Manage Brand'))
            ->getConfig()->getTitle()->prepend(__('Brand'));

        $this->_dataPersistor->clear('brand');

        return $resultPage;
    }
}