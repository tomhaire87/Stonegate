<?php

namespace AudereCommerce\Downloads\Model\Download\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Active implements OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();

        $options[] = array(
            'label' => 'No',
            'value' => 0
        );

        $options[] = array(
            'label' => 'Yes',
            'value' => 1
        );

        return $options;
    }
}