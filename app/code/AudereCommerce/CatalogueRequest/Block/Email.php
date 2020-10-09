<?php

namespace AudereCommerce\CatalogueRequest\Block;

use Magento\Framework\View\Element\Template;

class Email extends Template
{

    public function getGroupedParams()
    {
        $paramMap = array(
            'General' => array(
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'company' => 'Company',
                'phone_number' => 'Phone Number',
                'address' => 'Address',
                'town_city' => 'Town/City',
                'postcode' => 'Postcode',
                'website' => 'Website'
            )
        );

        $params = $this->getData('params')['form'];
        $groupedParams = array();

        foreach ($paramMap as $group => $values) {
            $groupedParams[$group] = array();

            foreach ($values as $code => $label) {
                $value = isset($params[$code]) ? $params[$code] : '';
                $groupedParams[$group][$label] = $value;
            }
        }

        return $groupedParams;
    }

    public function getDownloadGroupedParams()
    {
        $paramMap = array(
            'General' => array(
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'phone_number' => 'Phone Number',
                'email_address' => 'Email Address'
            )
        );

        $params = $this->getData('params')['form'];
        $groupedParams = array();

        foreach ($paramMap as $group => $values) {
            $groupedParams[$group] = array();

            foreach ($values as $code => $label) {
                $value = isset($params[$code]) ? $params[$code] : '';
                $groupedParams[$group][$label] = $value;
            }
        }

        return $groupedParams;
    }

}
