<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Customer;

use Magento\Framework\Option\ArrayInterface;

class EmailField implements ArrayInterface
{

    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'email_address',
                'label' => 'Email Address'
            ),
            array(
                'value' => 'user_field_1',
                'label' => 'User Field 1'
            ),
            array(
                'value' => 'user_field_2',
                'label' => 'User Field 2'
            ),
            array(
                'value' => 'user_field_3',
                'label' => 'User Field 3'
            ),
            array(
                'value' => 'user_field_4',
                'label' => 'User Field 4'
            ),
            array(
                'value' => 'user_field_5',
                'label' => 'User Field 5'
            ),
            array(
                'value' => 'user_field_6',
                'label' => 'User Field 6'
            ),
            array(
                'value' => 'user_field_7',
                'label' => 'User Field 7'
            ),
            array(
                'value' => 'user_field_8',
                'label' => 'User Field 8'
            ),
            array(
                'value' => 'user_field_9',
                'label' => 'User Field 9'
            ),
            array(
                'value' => 'user_field_10',
                'label' => 'User Field 10'
            ),
            array(
                'value' => 'custom_text_1',
                'label' => 'Custom Text 1'
            ),
            array(
                'value' => 'custom_text_2',
                'label' => 'Custom Text 2'
            ),
            array(
                'value' => 'custom_text_3',
                'label' => 'Custom Text 3'
            ),
            array(
                'value' => 'custom_text_4',
                'label' => 'Custom Text 4'
            )
        );
    }

}
