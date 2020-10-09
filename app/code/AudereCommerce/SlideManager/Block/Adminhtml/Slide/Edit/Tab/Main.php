<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slide\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use AudereCommerce\SlideManager\Model\System\Config\Slider as SliderConfig;
use AudereCommerce\SlideManager\Model\System\Config\Subtitle\Position as SubtitlePositionConfig;


class Main extends Generic implements TabInterface
{

    protected $_sliderConfig;
    protected $_subtitlePositionConfig;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        SliderConfig $sliderConfig,
        SubtitlePositionConfig $subtitlePositionConfig,
        array $data = []
    )
    {
        $this->_sliderConfig = $sliderConfig;
        $this->_subtitlePositionConfig = $subtitlePositionConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('slide_');
        $form->setFieldNameSuffix('slide');

        $model = $this->_coreRegistry->registry('slidemanager_slide');

        $general = $form->addFieldset('base_fieldset', array(
            'legend' => __('General')
        ));

        if ($model->getId()) {
            $general->addField('slide_id', 'hidden', array(
                'name' => 'slide_id'
            ));
        }

        $general->addField('identifier', 'text', array(
            'name' => 'identifier',
            'label' => __('Identifier'),
            'required' => true
        ));

        $general->addField('slider_id', 'select', array(
            'name' => 'slider_id',
            'label' => __('Slider'),
            'options' => $this->_sliderConfig->toOptionArray(),
            'required' => false
        ));

		$general->addField('position', 'text', array(
			'name'		=> 'position',
			'label'		=> __('Position'),
			'required'	=> false
		));

        $general->addField('title', 'text', array(
            'name' => 'title',
            'label' => __('Title'),
            'required' => false
        ));

        $general->addField('subtitle', 'text', array(
            'name' => 'subtitle',
            'label' => __('Subtitle'),
            'required' => false
        ));

        // TODO Change to textarea with wysiwyg editor
        $general->addField('content', 'text', array(
            'name' => 'content',
            'label' => __('Content'),
            'required' => false
        ));

        $general->addField('button_text', 'text', array(
            'name' => 'button_text',
            'label' => __('Button Text'),
            'required' => false
        ));

        $general->addField('link', 'text', array(
            'name' => 'link',
            'label' => __('URL'),
            'required' => false
        ));

        $media = $form->addFieldset('media_fieldset', array(
            'legend' => __('Media')
        ));

        if ($model->getId()) {
            $model->setImage('slidemanager/images' . $model->getImage());
            $model->setSmallImage('slidemanager/images' . $model->getSmallImage());
        }

        // Todo Add comments for recommended usage, E.g. size & resolution image shows
        $media->addField('image', 'image', array(
            'title' => __('Base Image'),
            'label' => __('Base Image'),
            'name' => 'image',
            'required' => true,
            'note' => __('Allowed image types: jpg, jpeg, gif, png'),
        ));

        // Todo Add comments for recommended usage, E.g. size & resolution image shows
        $media->addField('small_image', 'image', array(
            'title' => __('Small Image'),
            'label' => __('Small Image'),
            'name' => 'small_image',
            'required' => true,
            'note' => __('Allowed image types: jpg, jpeg, gif, png'),
        ));

        $customise = $form->addFieldset('customisation_fieldset', array(
            'legend' => __('Customisation')
        ));

        // TODO Create colour picker attribute
        $customise->addField('title_colour', 'text', array(
            'name' => 'title_colour',
            'label' => __('Title Colour'),
            'required' => false
        ));

        // TODO Create colour picker attribute
        $customise->addField('subtitle_colour', 'text', array(
            'name' => 'subtitle_colour',
            'label' => __('Subtitle Colour'),
            'required' => false
        ));

        $customise->addField('subtitle_position', 'select', array(
            'name' => 'subtitle_position',
            'label' => __('Subtitle Position'),
            'options' => $this->_subtitlePositionConfig->toOptionArray(),
            'required' => false
        ));

        // TODO Create colour picker attribute
        $customise->addField('button_text_colour', 'text', array(
            'name' => 'button_text_colour',
            'label' => __('Button Text Colour'),
            'required' => false
        ));

        // TODO Create colour picker attribute
        $customise->addField('button_background_colour', 'text', array(
            'name' => 'button_background_colour',
            'label' => __('Button Background Colour'),
            'required' => false
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Slide');
    }

    public function getTabTitle()
    {
        return __('Slide');
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