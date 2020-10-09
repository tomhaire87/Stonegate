<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Download;

interface OrderDetailSearchResultsInterface
{
    /**
     * @return OrderDetailInterface[]
     */
    public function getItems();
}
