<?php

namespace AudereCommerce\SlideManager\Model\System\Config;

use \Magento\Framework\Option\ArrayInterface;

class Location implements ArrayInterface
{

    public function toOptionArray()
    {
        $options = array(
            'homepage' => 'Homepage',
            'about' => 'About Us',
            'trade' => 'Trade Account'
        );

        return $options;
    }

}