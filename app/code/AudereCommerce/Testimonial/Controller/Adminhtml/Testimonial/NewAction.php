<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

class NewAction extends Testimonial
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial_save';

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/edit');
    }
}