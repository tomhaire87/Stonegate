<?php

namespace AudereCommerce\BrandManager\Api;

use \Magento\Catalog\Api\Data\CategoryInterface;
use AudereCommerce\BrandManager\Model\Brand;

interface BrandManagementInterface
{

    /**
     * @param Brand $model
     * @return CategoryInterface
     */
    public function getCategory(Brand $model);
}