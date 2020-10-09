<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\Download;

use AudereCommerce\Downloads\Controller\Adminhtml\Download;

class Delete extends Download
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $downloadRepository = $this->_downloadRepositoryInterface->getById($id);
                $this->_downloadRepositoryInterface->delete($downloadRepository);
                $this->messageManager->addSuccessMessage(__('The Download has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}