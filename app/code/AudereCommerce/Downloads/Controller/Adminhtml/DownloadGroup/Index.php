<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

class Index extends DownloadGroup
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download_group')
            ->addBreadcrumb(__('Manage Download Group'), __('Manage Download Group'))
            ->getConfig()->getTitle()->prepend(__('Download Group'));

        $this->_dataPersistor->clear('download_group');

        return $resultPage;
    }
}