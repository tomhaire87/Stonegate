<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

class Index extends DownloadType
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download_type')
            ->addBreadcrumb(__('Manage Download Type'), __('Manage Download Type'))
            ->getConfig()->getTitle()->prepend(__('Download Type'));

        $this->_dataPersistor->clear('download_type');

        return $resultPage;
    }
}