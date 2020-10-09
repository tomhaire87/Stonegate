<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements CustomerSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\Customer', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\Customer');
    }
}
