<?php

namespace AudereCommerce\SlideManager\Model\System\Config;

use \Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{

    public function toOptionArray()
    {
        $options = array(
            0 => 'Disabled',
            1 => 'Enabled'
        );

        return $options;
    }

}