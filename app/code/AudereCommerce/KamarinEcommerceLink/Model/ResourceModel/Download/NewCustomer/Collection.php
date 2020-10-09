<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Download\NewCustomerSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements NewCustomerSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Download\NewCustomer', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Download\NewCustomer');
    }
}
