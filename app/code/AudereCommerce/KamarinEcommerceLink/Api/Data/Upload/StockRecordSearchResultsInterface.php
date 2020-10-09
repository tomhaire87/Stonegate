<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

interface StockRecordSearchResultsInterface
{
    /**
     * @return StockRecordInterface[]
     */
    public function getItems();
}
