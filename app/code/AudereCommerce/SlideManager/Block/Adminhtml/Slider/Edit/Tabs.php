<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{

    protected function _construct()
    {
        parent::_construct();

        $this->setId('slider_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Slider'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('slider_main', array(
            'label' => __('General'),
            'title' => __('General'),
            'content' => $this->getLayout()->createBlock('AudereCommerce\SlideManager\Block\Adminhtml\Slider\Edit\Tab\Main')->toHtml(),
            'active' => true
        ));

        return parent::_beforeToHtml();
    }

}