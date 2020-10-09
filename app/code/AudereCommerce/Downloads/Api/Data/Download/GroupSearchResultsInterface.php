<?php

namespace AudereCommerce\Downloads\Api\Data\Download;

use AudereCommerce\Downloads\Api\Data\Download\GroupInterface;

interface GroupSearchResultsInterface
{

    /**
     * @return GroupInterface[]
     */
    public function getItems();
}