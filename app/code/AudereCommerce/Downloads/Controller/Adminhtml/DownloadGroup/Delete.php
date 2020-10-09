<?php

namespace AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

use AudereCommerce\Downloads\Controller\Adminhtml\DownloadGroup;

class Delete extends DownloadGroup
{

    const ADMIN_RESOURCE = 'AudereCommerce_Downloads::download_group_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $groupRepository = $this->_groupRepositoryInterface->getById($id);
                $this->_groupRepositoryInterface->delete($groupRepository);
                $this->messageManager->addSuccessMessage(__('The Download Group has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}