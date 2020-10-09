<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadType;

class Delete extends DownloadType
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_type_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $typeRepository = $this->_typeRepositoryInterface->getById($id);
                $this->_typeRepositoryInterface->delete($typeRepository);
                $this->messageManager->addSuccessMessage(__('The Download Type has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}