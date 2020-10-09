<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

use \AudereCommerce\KamarinEcommerceLink\Model\ResourceModel\Upload\StockQuantities;

interface StockQuantitiesInterface
{
    const ENTITY_TYPE = 'stock_quantities';

    /**
      * @return StockQuantities
      */
    public function getResource();

}
