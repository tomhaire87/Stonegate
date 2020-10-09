<?php

namespace AudereCommerce\BrandManager\Model;

use \Magento\Catalog\Api\Data\CategoryInterface;
use \Magento\Catalog\Model\CategoryRepository;
use AudereCommerce\BrandManager\Api\BrandManagementInterface;
use AudereCommerce\BrandManager\Model\Brand;

class BrandManagement implements BrandManagementInterface
{

    /**
     * @var CategoryRepository
     */
    protected $_categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * @param Brand $model
     * @return CategoryInterface
     */
    public function getCategory(Brand $model)
    {
        return $this->_categoryRepository->get($model->getData('category_id'));
    }
}