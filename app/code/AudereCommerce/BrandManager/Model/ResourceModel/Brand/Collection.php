<?php

namespace AudereCommerce\BrandManager\Model\ResourceModel\Brand;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\BrandManager\Api\Data\BrandSearchResultsInterface;

class Collection extends AbstractCollection implements BrandSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\BrandManager\Model\Brand', 'AudereCommerce\BrandManager\Model\ResourceModel\Brand');
    }
}