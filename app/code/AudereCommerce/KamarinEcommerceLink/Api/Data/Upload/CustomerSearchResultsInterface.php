<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Data\Upload;

interface CustomerSearchResultsInterface
{
    /**
     * @return CustomerInterface[]
     */
    public function getItems();
}
