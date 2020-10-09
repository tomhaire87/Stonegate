<?php

namespace AudereCommerce\Downloads\Model;

use \AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use \AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use \AudereCommerce\Downloads\Model\Download\GroupRepository;
use \AudereCommerce\Downloads\Model\Download\TypeRepository;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use \Magento\Catalog\Model\ProductRepository;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Framework\App\ResourceConnection;
use AudereCommerce\Downloads\Api\DownloadManagementInterface;
use AudereCommerce\Downloads\Model\Download;

class DownloadManagement implements DownloadManagementInterface
{

    /**
     * @var GroupRepository
     */
    protected $_groupRepository;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var TypeRepository
     */
    protected $_typeRepository;

    /**
     * @param TypeRepository $typeRepository
     * @param GroupRepository $groupRepository
     * @param ResourceConnection $resource
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductRepository $productRepository
     */
    public function __construct(TypeRepository $typeRepository, GroupRepository $groupRepository, ResourceConnection $resource, SearchCriteriaBuilder $searchCriteriaBuilder, ProductRepository $productRepository)
    {
        $this->_typeRepository = $typeRepository;
        $this->_groupRepository = $groupRepository;
        $this->_resource = $resource;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_productRepository = $productRepository;
    }

    /**
     * @param Download $model
     * @return TypeInterface
     */
    public function getType(Download $model)
    {
        return $this->_typeRepository->getById($model->getData('type_id'));
    }

    /**
     * @param Download $model
     * @return GroupInterface
     */
    public function getGroup(Download $model)
    {
        return $this->_groupRepository->getById($model->getData('group_id'));
    }

    /**
     * @param Download $model
     * @return ProductSearchResultsInterface
     */
    public function getProducts(Download $model)
    {
        $connection = $this->_resource->getConnection();

        $select = $connection->select()
            ->from($this->_resource->getTableName('auderecommerce_downloads_download_product'))
            ->where('download_id = ?', $model->getId());

        $productIds = array();

        foreach ($connection->fetchAll($select) as $row) {
            $productIds[] = $row['catalog_product_entity_id'];
        }

        $searchCriteria = $this->_searchCriteriaBuilder
            ->addFilter('entity_id', $productIds, 'in')
            ->create();

        return $this->_productRepository->getList($searchCriteria);
    }
}