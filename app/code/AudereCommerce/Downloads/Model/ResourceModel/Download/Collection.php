<?php

namespace AudereCommerce\Downloads\Model\ResourceModel\Download;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\Downloads\Api\Data\DownloadSearchResultsInterface;

class Collection extends AbstractCollection implements DownloadSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\Downloads\Model\Download', 'AudereCommerce\Downloads\Model\ResourceModel\Download');
    }
}