<?php

namespace AudereCommerce\ReCaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ReCaptcha extends Template
{

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param Context $context
     * @param array $data
     */
    function __construct(
        Context $context,
        array $data = array()
    )
    {
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getSiteKey()
    {
        return $this->_scopeConfig->getValue('auderecommerce_recaptcha/general/site_key');
    }

    /**
     * @return bool
     */
    public function isRecaptchaEnabled()
    {
        return $this->_scopeConfig->getValue('auderecommerce_recaptcha/general/status');
    }

}