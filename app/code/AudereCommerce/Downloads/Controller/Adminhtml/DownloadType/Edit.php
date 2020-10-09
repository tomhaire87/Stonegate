<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends DownloadType
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_typeFactory->create();
        } else {
            try {
                $model = $this->_typeRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Download Type no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('download_type', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Download Type') : __('New Download Type');

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download type')
            ->addBreadcrumb(__('Manage Download Type'), __('Manage Download Type'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Download Type'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}