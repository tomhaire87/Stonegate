<?php

namespace AudereCommerce\AccountRequest\Block;

use Magento\Framework\View\Element\Template;

class Email extends Template
{

    public function getGroupedParams()
    {
//        $paramMap = array(
//            'General' => array(
//                'registered_company_name' => 'Registered Company Name',
//                'registered_company_number' => 'Registered Company Number',
//                'vat_no' => 'VAT No',
//                'tel_number' => 'Telephone Number',
//                'email_address' => 'Email Address',
//                'web_address' => 'Web Address',
//                'address_line_1' => 'Address Line 1',
//                'address_line_2' => 'Address Line 2',
//                'town_city' => 'Town/City',
//                'county' => 'County',
//                'country' => 'Country',
//                'postcode' => 'Postcode'
//            ),
//            'Accounts' => array(
//                'contact_name' => 'Contact Name',
//                'bank_name_address' => 'Bank Name & Address',
//                'sort_code' => 'Sort Code',
//                'credit_limit_requested' => 'Credit Limit Requested',
//                'account_number' => 'Account Number'
//            ),
//            'Trade Reference 1' => array(
//                'ref_1_company_name' => 'Company Name',
//                'ref_1_contact_person' => 'Contact Person',
//                'ref_1_address' => 'Address',
//                'ref_1_telephone' => 'Telephone'
//            ),
//            'Trade Reference 2' => array(
//                'ref_2_company_name' => 'Company Name',
//                'ref_2_contact_person' => 'Contact Person',
//                'ref_2_address' => 'Address',
//                'ref_2_telephone' => 'Telephone'
//            ),
//            'Credit Terms & Conditions' => array(
//                'name' => 'Name',
//                'date' => 'Date',
//                'title' => 'Title'
//            )
//        );

        $paramMap = array(
            'Company Information' => array(
                'full_company_title' => 'Full Company Title',
                'registered_company_number' => 'Registered Company Number',
                'vat_no' => 'VAT No',
                'tel_number' => 'Tel Number',
                'fax_number' => 'Fax Number',
                'email_address' => 'Email Address',
                'web_address' => 'Web Address'
            ),
            'Invoice Address' => array(
                'invoice_address_line_1' => 'Address Line 1',
                'invoice_address_line_2' => 'Address Line 2',
                'invoice_town_city' => 'Town/City',
                'invoice_county' => 'County',
                'invoice_country' => 'Country',
                'invoice_postcode' => 'Postcode'
            ),
            'Delivery Address' => array(
                'delivery_address_line_1' => 'Address Line 1',
                'delivery_address_line_2' => 'Address Line 2',
                'delivery_town_city' => 'Town/City',
                'delivery_county' => 'County',
                'delivery_country' => 'Country',
                'delivery_postcode' => 'Postcode'
            ),
            'Limited Company' => array(
                'limited_director_name' => 'Name of Director(s)',
                'limited_registration_number' => 'Registration Number',
                'limited_date_formation' => 'Date of Formation',
                'accounts_email' => 'Parent or Associated Companies',
                'limited_address_line_1' => 'Address Line 1',
                'limited_address_line_2' => 'Address Line 2',
                'limited_town_city' => 'Town/City',
                'limited_county' => 'County',
                'limited_country' => 'Country',
                'limited_postcode' => 'Postcode',
            ),
            'Accounts' => array(
                'accounts_contact' => 'Contact Name',
                'accounts_tel' => 'Tel Number',
                'accounts_fax' => 'Fax Number',
                'accounts_email' => 'Email',
                'accounts_bank_name' => 'Bank Name',
                'accounts_bank_address' => 'Bank Address',
                'accounts_sort_code' => 'Sort Code',
                'accounts_credit_limit' => 'Credit Limit Requested',
                'accounts_account_number' => 'Account Number',
                'email_invoice_check' => 'No Email Invoices & Statements'
            ),
            'Trade Reference 1' => array(
                'ref_1_company_name' => 'Company Name',
                'ref_1_contact_person' => 'Contact Person',
                'ref_1_address' => 'Address',
                'ref_1_telephone' => 'Telephone'
            ),
            'Trade Reference 2' => array(
                'ref_2_company_name' => 'Company Name',
                'ref_2_contact_person' => 'Contact Person',
                'ref_2_address' => 'Address',
                'ref_2_telephone' => 'Telephone'
            ),
            'Credit Terms & Conditions' => array(
                'name' => 'Name',
                'title' => 'Title',
                'date' => 'Date',
                'terms_agreement' => 'Read and accept Terms & Conditions'
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

        $traderCount = 0;

        foreach ($params['trader'] as $trader) {
            $traderCount++;

            if (isset($trader['name'])) {
                $groupedParams['Sole Trader ' . $traderCount]['Name of Director'] = $trader['name'];
            }

            if (isset($trader['dob'])) {
                $groupedParams['Sole Trader ' . $traderCount]['Date of Birth'] = $trader['dob'];
            }

            if (isset($trader['address'])) {
                $groupedParams['Sole Trader ' . $traderCount]['Home Address'] = $trader['address'];
            }

            if (isset($trader['tel'])) {
                $groupedParams['Sole Trader ' . $traderCount]['Tel Number'] = $trader['tel'];
            }
        }

        return $groupedParams;
    }

}
