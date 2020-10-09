<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slide\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{

    protected function _construct()
    {
        parent::_construct();

        $this->setId('slide_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Slide'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('slide_main', array(
            'label' => __('General'),
            'title' => __('General'),
            'content' => $this->getLayout()->createBlock('AudereCommerce\SlideManager\Block\Adminhtml\Slide\Edit\Tab\Main')->toHtml(),
            'active' => true
        ));

        return parent::_beforeToHtml();
    }

}