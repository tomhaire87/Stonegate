<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends DownloadGroup
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_groupFactory->create();
        } else {
            try {
                $model = $this->_groupRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Download Group no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('download_group', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Download Group') : __('New Download Group');

        $resultPage
            ->setActiveMenu('AudereCommerce_Downloads::download group')
            ->addBreadcrumb(__('Manage Download Group'), __('Manage Download Group'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Download Group'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}