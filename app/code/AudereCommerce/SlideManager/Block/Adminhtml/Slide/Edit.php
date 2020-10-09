<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slide;

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
        $this->_controller = 'adminhtml_slide';
        $this->_blockGroup = 'AudereCommerce_SlideManager';

        parent::_construct();
    }

    public function getHeaderText()
    {
        $slide = $this->_registry->registry('slidemanager_slide');

        if ($slide->getId()) {
            return __("Edit Slide '%1'", $this->escapeHtml($slide->getIdentifier()));
        } else {
            return __('Add Slide');
        }
    }

//    protected function _prepareLayout()
//    {
//        $this->_formScripts[] = "
//            function toggleEditor() {
//                if (tinyMCE.getInstanceById('post_content') == null) {
//                    tinyMCE.execCommand('mceAddControl', false, 'post_content');
//                } else {
//                    tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
//                }
//            };
//        ";
//
//        return parent::_prepareLayout();
//    }

}