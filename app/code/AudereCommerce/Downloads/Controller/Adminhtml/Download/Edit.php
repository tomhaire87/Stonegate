<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\Download;

use AudereCommerce\Downloads\Controller\Adminhtml\Download;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Download
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_downloadFactory->create();
        } else {
            try {
                $model = $this->_downloadRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Download no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('download', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Download') : __('New Download');

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download')
            ->addBreadcrumb(__('Manage Download'), __('Manage Download'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Download'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}