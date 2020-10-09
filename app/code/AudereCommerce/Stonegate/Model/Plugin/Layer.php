<?php

namespace AudereCommerce\Stonegate\Model\Plugin;

class Layer extends \Magento\CatalogInventory\Model\Plugin\Layer
{
    public function beforePrepareProductCollection(
        \Magento\Catalog\Model\Layer $subject,
        \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection $collection
    ) {
        return;        
    }
}