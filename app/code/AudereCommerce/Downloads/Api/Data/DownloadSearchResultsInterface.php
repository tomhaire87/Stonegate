<?php

namespace AudereCommerce\Downloads\Api\Data;

use AudereCommerce\Downloads\Api\Data\DownloadInterface;

interface DownloadSearchResultsInterface
{

    /**
     * @return DownloadInterface[]
     */
    public function getItems();
}