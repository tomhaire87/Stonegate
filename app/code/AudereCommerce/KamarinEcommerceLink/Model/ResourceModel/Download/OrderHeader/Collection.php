<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Download\OrderHeaderSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements OrderHeaderSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Download\OrderHeader', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\OrderHeader');
    }
}
