<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slider\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use AudereCommerce\SlideManager\Model\System\Config\Location as LocationConfig;
use AudereCommerce\SlideManager\Model\System\Config\Status as StatusConfig;

class Main extends Generic implements TabInterface
{

    protected $_locationConfig;
    protected $_statusConfig;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        LocationConfig $locationConfig,
        StatusConfig $statusConfig,
        array $data = []
    )
    {
        $this->_locationConfig = $locationConfig;
        $this->_statusConfig = $statusConfig;

        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');

        $model = $this->_coreRegistry->registry('slidemanager_slider');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => __('General')
        ));

        if ($model->getId()) {
            $fieldset->addField('slider_id', 'hidden', array(
                'name' => 'slider_id'
            ));
        }

        $fieldset->addField('identifier', 'text', array(
            'name' => 'identifier',
            'label' => __('Identifier'),
            'required' => true
        ));

        $fieldset->addField('location', 'select', array(
            'name' => 'location',
            'label' => __('Location'),
            'options' => $this->_locationConfig->toOptionArray(),
            'required' => true,
            'required' => true
        ));

        $fieldset->addField('status', 'select', array(
            'name' => 'status',
            'label' => __('Status'),
            'options' => $this->_statusConfig->toOptionArray(),
            'required' => true,
            'required' => true
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Slider');
    }

    public function getTabTitle()
    {
        return __('Slider');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}