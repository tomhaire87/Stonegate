<?php

namespace AudereCommerce\Downloads\Model\Download;

use \Magento\Framework\Model\AbstractModel;
use AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Api\Download\GroupManagementInterface;

class Group extends AbstractModel implements GroupInterface
{

    const CREATED_AT = 'created_at';

    const ID = 'id';

    const NAME = 'name';

    const UPDATED_AT = 'updated_at';

    const URL_KEY = 'url_key';

    /**
     * @var GroupManagementInterface
     */
    protected $_groupManagementInterface;

    /**
     * @param GroupManagementInterface $groupManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(GroupManagementInterface $groupManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_groupManagementInterface = $groupManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\Downloads\Model\ResourceModel\Download\Group');
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
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * @param string $urlKey
     * @return $this
     */
    public function setUrlKey($urlKey)
    {
        $this->setData(self::URL_KEY, (string)$urlKey);
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
     * @return DownloadSearchResultsInterface
     */
    public function getDownloads()
    {
        return $this->_groupManagementInterface->getDownloads($this);
    }
}