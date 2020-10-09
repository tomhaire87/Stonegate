<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate;

use \AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateSearchResultsInterface;
use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection implements VatRateSearchResultsInterface
{
    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\Upload\VatRate', 'AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\VatRate');
    }
}
