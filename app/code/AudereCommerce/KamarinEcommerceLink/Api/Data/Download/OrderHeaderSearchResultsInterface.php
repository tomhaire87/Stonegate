<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Download;

interface OrderHeaderSearchResultsInterface
{
    /**
     * @return OrderHeaderInterface[]
     */
    public function getItems();
}
