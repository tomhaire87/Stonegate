<?php

namespace AudereCommerce\Testimonial\Model\ResourceModel\Testimonial;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\Testimonial\Api\Data\TestimonialSearchResultsInterface;

class Collection extends AbstractCollection implements TestimonialSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\Testimonial\Model\Testimonial', 'AudereCommerce\Testimonial\Model\ResourceModel\Testimonial');
    }
}