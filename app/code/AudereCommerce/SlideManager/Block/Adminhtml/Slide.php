<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml;

use \Magento\Backend\Block\Widget\Grid\Container;

class Slide extends Container
{

    protected function _construct()
    {
        $this->_controller = 'adminhtml_slide';
        $this->_blockGroup = 'AudereCommerce_SlideManager';
        $this->_headerText = __('Manage Slides');
        $this->_addButtonLabel = __('Add Slide');
        parent::_construct();
    }

}