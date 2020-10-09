<?php

namespace AudereCommerce\Testimonial\Api\Data;

use AudereCommerce\Testimonial\Api\Data\TestimonialInterface;

interface TestimonialSearchResultsInterface
{

    /**
     * @return TestimonialInterface[]
     */
    public function getItems();
}