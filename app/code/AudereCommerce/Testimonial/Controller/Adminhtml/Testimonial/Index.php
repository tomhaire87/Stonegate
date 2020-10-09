<?php

namespace AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

use AudereCommerce\Testimonial\Controller\Adminhtml\Testimonial;

class Index extends Testimonial
{

    const ADMIN_RESOURCE = 'AudereCommerce_Testimonial::testimonial';

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();

        $resultPage
            ->setActiveMenu('AudereCommerce_Testimonial::testimonial')
            ->addBreadcrumb(__('Manage Testimonial'), __('Manage Testimonial'))
            ->getConfig()->getTitle()->prepend(__('Testimonial'));

        $this->_dataPersistor->clear('testimonial');

        return $resultPage;
    }
}