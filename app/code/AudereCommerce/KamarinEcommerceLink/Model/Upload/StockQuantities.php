<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Model\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\StockQuantitiesInterface;
use Magento\Framework\Model\AbstractModel;

class StockQuantities extends AbstractModel implements StockQuantitiesInterface
{

    protected function _construct()
    {
        $this->_init('AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities');
    }

}
