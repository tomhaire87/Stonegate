<?php

namespace AudereCommerce\SlideManager\Model\System\Config;

use \Magento\Framework\Option\ArrayInterface;
use \AudereCommerce\SlideManager\Model\ResourceModel\Slider\CollectionFactory as SliderCollectionFactory;

class Slider implements ArrayInterface
{

    protected $_sliderCollectionFactory;

    function __construct(SliderCollectionFactory $sliderCollectionFactory)
    {
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
    }

    public function toOptionArray()
    {
        $options = array();
        $options[''] = ' ';

        $sliders = $this->_sliderCollectionFactory->create();

        foreach ($sliders as $slide) {
            $options[$slide->getId()] = $slide->getIdentifier();
        }

        return $options;
    }

}