<?php

namespace AudereCommerce\Downloads\Model\ResourceModel\Download\Group;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\Downloads\Api\Data\Download\GroupSearchResultsInterface;

class Collection extends AbstractCollection implements GroupSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\Downloads\Model\Download\Group', 'AudereCommerce\Downloads\Model\ResourceModel\Download\Group');
    }
}