<?php

namespace AudereCommerce\Downloads\Api\Download;

use AudereCommerce\Downloads\Api\Data\DownloadInterface;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Model\Download\Type;

interface TypeManagementInterface
{

    /**
     * @param Type $model
     * @return DownloadSearchResultsInterface
     */
    public function getDownloads(Type $model);
}