<?php

namespace AudereCommerce\BrandManager\Api\Data;

use AudereCommerce\BrandManager\Api\Data\BrandInterface;

interface BrandSearchResultsInterface
{

    /**
     * @return BrandInterface[]
     */
    public function getItems();
}