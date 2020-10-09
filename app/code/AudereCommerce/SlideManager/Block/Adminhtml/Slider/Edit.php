<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{

    protected $_registry = null;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    )
    {
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'AudereCommerce_SlideManager';

        parent::_construct();
    }

    public function getHeaderText()
    {
        $slider = $this->_registry->registry('slidemanager_slider');

        if ($slider->getId()) {
            return __("Edit Slider '%1'", $this->escapeHtml($slider->getIdentifier()));
        } else {
            return __('Add Slider');
        }
    }

}