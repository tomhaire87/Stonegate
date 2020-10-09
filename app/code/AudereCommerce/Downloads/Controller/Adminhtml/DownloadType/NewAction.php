<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

class NewAction extends DownloadType
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}