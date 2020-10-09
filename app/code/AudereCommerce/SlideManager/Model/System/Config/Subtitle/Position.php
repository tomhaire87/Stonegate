<?php

namespace AudereCommerce\SlideManager\Model\System\Config\Subtitle;

use \Magento\Framework\Option\ArrayInterface;

class Position implements ArrayInterface
{

    public function toOptionArray()
    {
        $options = array(
            '' => ' ',
            'before' => 'Before Title',
            'after' => 'After Title'
        );

        return $options;
    }

}