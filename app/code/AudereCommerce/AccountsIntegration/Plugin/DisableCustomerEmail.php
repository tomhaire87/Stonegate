<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Registry;

class DisableCustomerEmail
{

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    public function __construct(
        Registry $registry,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_registry = $registry;
        $this->_scopeConfig = $scopeConfig;
    }

    public function aroundNewAccount(\Magento\Customer\Model\EmailNotification $subject, \Closure $proceed, ...$args)
    {
        if (!intval($this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/send_emails')) && $this->_registry->registry('disable_account_email') == true) {
            return $subject;
        }

        return $proceed(...$args);
    }

}