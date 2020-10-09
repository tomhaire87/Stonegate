<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements StockQuantitiesSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\StockQuantities', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities');
    }
}
