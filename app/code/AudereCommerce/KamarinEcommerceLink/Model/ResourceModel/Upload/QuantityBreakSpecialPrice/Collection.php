<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\QuantityBreakSpecialPriceSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements QuantityBreakSpecialPriceSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\QuantityBreakSpecialPrice', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\QuantityBreakSpecialPrice');
    }
}
