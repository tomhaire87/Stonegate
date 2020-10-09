<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\CustomerSpecialPriceSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements CustomerSpecialPriceSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\CustomerSpecialPrice', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\CustomerSpecialPrice');
    }
}
