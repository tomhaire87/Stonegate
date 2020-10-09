<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\Download;

use AudereCommerce\Downloads\Controller\Adminhtml\Download;

class NewAction extends Download
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}