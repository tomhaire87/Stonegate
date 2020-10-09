<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Testimonial
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial_save';

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!$id) {
            $model = $this->_testimonialFactory->create();
        } else {
            try {
                $model = $this->_testimonialRepositoryInterface->getById($id);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('Testimonial no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_registry->register('testimonial', $model);

        $resultPage = $this->_resultPageFactory->create();

        $editType = $id ? __('Edit Testimonial') : __('New Testimonial');

        $resultPage
            ->setActiveMenu('AudereCommerce_Testimonial::testimonial')
            ->addBreadcrumb(__('Manage Testimonial'), __('Manage Testimonial'))
            ->addBreadcrumb($editType, $editType);

        $resultPage->getConfig()->getTitle()->prepend(__('Testimonial'));
        /* $resultPage->getConfig()->getTitle()->prepend(); */

        return $resultPage;
    }
}