<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

use AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

class Delete extends Brand
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $brandRepository = $this->_brandRepositoryInterface->getById($id);
                $this->_brandRepositoryInterface->delete($brandRepository);
                $this->messageManager->addSuccessMessage(__('The Brand has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}