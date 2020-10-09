<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml;

use \Magento\Backend\Block\Widget\Grid\Container;

class Slider extends Container
{

    protected function _construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'AudereCommerce_SliderManager';
        $this->_headerText = __('Manage Sliders');
        $this->_addButtonLabel = __('Add Slider');
        parent::_construct();
    }

}