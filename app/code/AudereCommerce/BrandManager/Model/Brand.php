<?php

namespace AudereCommerce\BrandManager\Model;

use \Magento\Catalog\Api\Data\CategoryInterface;
use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\BrandManager\Api\BrandManagementInterface;
use AudereCommerce\BrandManager\Api\Data\BrandInterface;

class Brand extends AbstractModel implements BrandInterface
{

    const CATEGORY_ID = 'category_id';

    const CREATED_AT = 'created_at';

    const DESCRIPTION = 'description';

    const ID = 'id';

    const IMAGE = 'image';

    const NAME = 'name';

    const UPDATED_AT = 'updated_at';

    /**
     * @var BrandManagementInterface
     */
    protected $_brandManagementInterface;

    /**
     * @param BrandManagementInterface $brandManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(BrandManagementInterface $brandManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_brandManagementInterface = $brandManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\BrandManager\Model\ResourceModel\Brand');
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
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->setData(self::DESCRIPTION, (string)$description);
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
     * @return int
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId($categoryId)
    {
        $this->setData(self::CATEGORY_ID, (int)$categoryId);
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

    /**
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->_brandManagementInterface->getCategory($this);
    }
}