<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

class NewAction extends DownloadGroup
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}