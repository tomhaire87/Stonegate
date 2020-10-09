<?php

namespace AudereCommerce\Downloads\Api\Data;

use \AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use \AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use AudereCommerce\Downloads\Model\ResourceModel\Download;

interface DownloadInterface
{

    const ENTITY_TYPE = 'download';

    /**
     * @return Download
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
     * @return int
     */
    public function getTypeId();

    /**
     * @param int $typeId
     * @return $this
     */
    public function setTypeId($typeId);

    /**
     * @return int
     */
    public function getGroupId();

    /**
     * @param int $groupId
     * @return $this
     */
    public function setGroupId($groupId);

    /**
     * @return string
     */
    public function getPath();

    /**
     * @param string $path
     * @return $this
     */
    public function setPath($path);

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

    /**
     * @return TypeInterface
     */
    public function getType();

    /**
     * @return GroupInterface
     */
    public function getGroup();

    /**
     * @return ProductSearchResultsInterface
     */
    public function getProducts();
}