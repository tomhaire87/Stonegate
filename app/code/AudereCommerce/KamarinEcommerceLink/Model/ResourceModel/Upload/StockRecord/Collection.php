<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockRecordSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements StockRecordSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\StockRecord', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockRecord');
    }
}
