<?php

namespace AudereCommerce\Downloads\Api\Data\Download;

use AudereCommerce\Downloads\Api\Data\Download\TypeInterface;

interface TypeSearchResultsInterface
{

    /**
     * @return TypeInterface[]
     */
    public function getItems();
}