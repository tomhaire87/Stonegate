<?php

namespace AudereCommerce\Downloads\Api\Download;

use AudereCommerce\Downloads\Api\Data\DownloadInterface;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;
use AudereCommerce\Downloads\Model\Download\Group;

interface GroupManagementInterface
{

    /**
     * @param Group $model
     * @return DownloadSearchResultsInterface
     */
    public function getDownloads(Group $model);
}