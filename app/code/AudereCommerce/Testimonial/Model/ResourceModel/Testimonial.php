<?php

namespace AudereCommerce\Testimonial\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb
{

    public function _construct()
    {
        $this->_init('auderecommerce_testimonial_testimonial', 'id');
    }
}