<?php

namespace AudereCommerce\Testimonial\Model;

use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\Testimonial\Api\Data\TestimonialInterface;

class Testimonial extends AbstractModel implements TestimonialInterface
{

    const ACTIVE = 'active';

    const COMPANY = 'company';

    const CREATED_AT = 'created_at';

    const ID = 'id';

    const IMAGE = 'image';

    const NAME = 'name';

    const TESTIMONIAL = 'testimonial';

    const UPDATED_AT = 'updated_at';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\Testimonial\Model\ResourceModel\Testimonial');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData(self::ID, (int)$id);
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->setData(self::NAME, (string)$name);
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->getData(self::COMPANY);
    }

    /**
     * @param string $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->setData(self::COMPANY, (string)$company);
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->setData(self::IMAGE, (string)$image);
        return $this;
    }

    /**
     * @return string
     */
    public function getTestimonial()
    {
        return $this->getData(self::TESTIMONIAL);
    }

    /**
     * @param string $testimonial
     * @return $this
     */
    public function setTestimonial($testimonial)
    {
        $this->setData(self::TESTIMONIAL, (string)$testimonial);
        return $this;
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->getData(self::ACTIVE);
    }

    /**
     * @param int $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->setData(self::ACTIVE, (int)$active);
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(self::CREATED_AT, (string)$createdAt);
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(self::UPDATED_AT, (string)$updatedAt);
        return $this;
    }
}