<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

class Delete extends Testimonial
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial_delete';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $testimonialRepository = $this->_testimonialRepositoryInterface->getById($id);
                $this->_testimonialRepositoryInterface->delete($testimonialRepository);
                $this->messageManager->addSuccessMessage(__('The Testimonial has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}