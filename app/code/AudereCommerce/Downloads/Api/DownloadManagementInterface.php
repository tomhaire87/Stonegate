<?php

namespace AudereCommerce\Downloads\Api;

use \AudereCommerce\Downloads\Api\Data\Download\GroupInterface;
use \AudereCommerce\Downloads\Api\Data\Download\TypeInterface;
use \Magento\Catalog\Api\Data\ProductInterface;
use \Magento\Catalog\Api\Data\ProductSearchResultsInterface;
use AudereCommerce\Downloads\Model\Download;

interface DownloadManagementInterface
{

    /**
     * @param Download $model
     * @return TypeInterface
     */
    public function getType(Download $model);

    /**
     * @param Download $model
     * @return GroupInterface
     */
    public function getGroup(Download $model);

    /**
     * @param Download $model
     * @return ProductSearchResultsInterface
     */
    public function getProducts(Download $model);
}