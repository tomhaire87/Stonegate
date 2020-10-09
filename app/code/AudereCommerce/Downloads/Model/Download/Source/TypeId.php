<?php

namespace AudereCommerce\Downloads\Model\Download\Source;

use Magento\Framework\Data\OptionSourceInterface;

class TypeId implements OptionSourceInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();

        $options[] = array(
            'label' => 'bar',
            'value' => 'foo'
        );

        $options[] = array(
            'label' => 'foo',
            'value' => 'bar'
        );

        $options[] = array(
            'label' => '123',
            'value' => 6
        );

        return $options;
    }
}