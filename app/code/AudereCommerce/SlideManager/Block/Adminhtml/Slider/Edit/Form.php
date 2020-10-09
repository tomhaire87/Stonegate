<?php

namespace AudereCommerce\SlideManager\Block\Adminhtml\Slider\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(array(
            'data' => array(
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}