<?php

namespace AudereCommerce\Downloads\Model\ResourceModel\Download\Type;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use AudereCommerce\Downloads\Api\Data\Download\TypeSearchResultsInterface;

class Collection extends AbstractCollection implements TypeSearchResultsInterface
{

    public function _construct()
    {
        $this->_init('AudereCommerce\Downloads\Model\Download\Type', 'AudereCommerce\Downloads\Model\ResourceModel\Download\Type');
    }
}