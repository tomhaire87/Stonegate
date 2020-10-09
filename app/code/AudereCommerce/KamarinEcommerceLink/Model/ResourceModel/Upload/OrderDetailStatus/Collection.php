<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\OrderDetailStatusSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements OrderDetailStatusSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\OrderDetailStatus', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\OrderDetailStatus');
    }
}
