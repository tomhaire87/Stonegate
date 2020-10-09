<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\Download;

use AudereCommerce\Downloads\Controller\Adminhtml\Download;

class Index extends Download
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download')
            ->addBreadcrumb(__('Manage Download'), __('Manage Download'))
            ->getConfig()->getTitle()->prepend(__('Download'));

        $this->_dataPersistor->clear('download');

        return $resultPage;
    }
}