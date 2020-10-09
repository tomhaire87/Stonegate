<?php

namespace AudereCommerce\Testimonial\Api;

use \Magento\Framework\Api\SearchCriteriaInterface;
use AudereCommerce\Testimonial\Api\Data\TestimonialInterface;
use AudereCommerce\Testimonial\Api\Data\TestimonialSearchResultsInterface;

interface TestimonialRepositoryInterface
{

    /**
     * @param TestimonialInterface $testimonial
     * @return TestimonialInterface
     */
    public function save(TestimonialInterface $testimonial);

    /**
     * @param int $id
     * @param bool $forceReload
     * @return TestimonialInterface
     */
    public function getById($id, $forceReload = false);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TestimonialSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param TestimonialInterface $testimonial
     * @return bool
     */
    public function delete(TestimonialInterface $testimonial);
}