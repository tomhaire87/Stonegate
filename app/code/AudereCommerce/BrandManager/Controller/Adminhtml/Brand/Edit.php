<?php

namespace AudereCommerce\BrandManager\Controller\Adminhtml\Brand;

use AudereCommerce\BrandManager\Controller\Adminhtml\Brand;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Brand
{

    const ADMIN_RESOURCE = 'AudereCommerce_BrandManager::brand_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_brandFactory->create();
        } else {
            try {
                $model = $this->_brandRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Brand no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('brand', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Brand') : __('New Brand');

        $resultPage
            ->setActiveMenu('AudereCommerce_BrandManager::brand')
            ->addBreadcrumb(__('Manage Brand'), __('Manage Brand'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Brand'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}