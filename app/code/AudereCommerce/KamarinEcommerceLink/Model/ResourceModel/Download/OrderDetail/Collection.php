<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderDetailSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements OrderDetailSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Download\OrderDetail', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderDetail');
    }
}
