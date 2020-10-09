<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderHeaderStatusSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements OrderHeaderStatusSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\OrderHeaderStatus', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderHeaderStatus');
    }
}
