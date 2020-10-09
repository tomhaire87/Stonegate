<?php

namespace AudereCommerce\ReCaptcha\Model\Config\Source;

class Type implements \Magento\Framework\Option\ArrayInterface
{

    const RECAPTCHA_TYPE_V2 = 1;
    const RECAPTCHA_TYPE_INVSIBILE = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 1,
                'label' => __('reCAPTCHA V2')
            )//,
//          array(
//              'value' => 2,
//              'label' => __('Invisible reCAPTCHA')
//          )
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            1 => __('reCAPTCHA V2')//,
//          2 => __('Invisible reCAPTCHA')
        );
    }

}
