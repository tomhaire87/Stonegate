<?php

namespace AudereCommerce\Downloads\Model;

use \AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use \AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\Downloads\Api\Data\DownloadInterface;
use AudereCommerce\Downloads\Api\DownloadManagementInterface;

class Download extends AbstractModel implements DownloadInterface
{

    const ACTIVE = 'active';

    const CREATED_AT = 'created_at';

    const GROUP_ID = 'group_id';

    const ID = 'id';

    const NAME = 'name';

    const PATH = 'path';

    const TYPE_ID = 'type_id';

    const UPDATED_AT = 'updated_at';

    /**
     * @var DownloadManagementInterface
     */
    protected $_downloadManagementInterface;

    /**
     * @param DownloadManagementInterface $downloadManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(DownloadManagementInterface $downloadManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_downloadManagementInterface = $downloadManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\Downloads\Model\ResourceModel\Download');
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
     * @return int
     */
    public function getTypeId()
    {
        return $this->getData(self::TYPE_ID);
    }

    /**
     * @param int $typeId
     * @return $this
     */
    public function setTypeId($typeId)
    {
        $this->setData(self::TYPE_ID, (int)$typeId);
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->getData(self::GROUP_ID);
    }

    /**
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId)
    {
        $this->setData(self::GROUP_ID, (int)$groupId);
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getData(self::PATH);
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->setData(self::PATH, (string)$path);
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

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->_downloadManagementInterface->getType($this);
    }

    /**
     * @return GroupInterface
     */
    public function getGroup()
    {
        return $this->_downloadManagementInterface->getGroup($this);
    }

    /**
     * @return ProductSearchResultsInterface
     */
    public function getProducts()
    {
        return $this->_downloadManagementInterface->getProducts($this);
    }
}