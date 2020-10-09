<?php

namespace AudereCommerce\Testimonial\Api\Data;

use AudereCommerce\Testimonial\Model\ResourceModel\Testimonial;

interface TestimonialInterface
{

    const ENTITY_TYPE = 'testimonial';

    /**
     * @return Testimonial
     */
    public function getResource();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getCompany();

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany($company);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getTestimonial();

    /**
     * @param string $testimonial
     * @return $this
     */
    public function setTestimonial($testimonial);

    /**
     * @return int
     */
    public function getActive();

    /**
     * @param int $active
     * @return $this
     */
    public function setActive($active);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}