<?php

namespace AudereCommerce\ReCaptcha\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ReCaptcha implements ObserverInterface
{

    /**
     * @var ManagerInterface $_messageManager
     */
    protected $_messageManager;

    /**
     * @var RedirectInterface $_redirect
     */
    protected $_redirect;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var ActionFlag
     */
    protected $_actionFlag;

    /**
     * @param ManagerInterface $messageManager
     * @param RedirectInterface $redirect
     * @param ActionFlag $actionFlag
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ManagerInterface $messageManager,
        RedirectInterface $redirect,
        ActionFlag $actionFlag,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->_messageManager = $messageManager;
        $this->_redirect = $redirect;
        $this->_actionFlag = $actionFlag;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @param Observer $observer
     * @return Observer
     */
    public function execute(Observer $observer)
    {
        if ($this->_isRecaptchaEnabled()) {
            $request = $observer->getRequest();
            $recaptchaResponse = $request->getPost('g-recaptcha-response');

            if (!$this->_validateResponse($recaptchaResponse)) {
                $this->_messageManager->addError(__('Invalid reCaptcha.'));
                $this->_actionFlag->set('', Action::FLAG_NO_DISPATCH, true);
                $this->_redirect->redirect($observer->getControllerAction()->getResponse(), '*/*/index');
            }
        }

        return $observer;
    }

    /**
     * @param string $response
     * @return bool
     */
    protected function _validateResponse($response)
    {
        $verifyQuery = array(
            'secret' => $this->_getSecretKey(),
            'response' => $response
        );

        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify' . '?' . http_build_query($verifyQuery);

        $rawResponse = file_get_contents($verifyUrl);
        $response = json_decode($rawResponse);

        if ($response->success) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function _isRecaptchaEnabled()
    {
        return $this->_scopeConfig->getValue('auderecommerce_recaptcha/general/status');
    }

    /**
     * @return string
     */
    protected function _getSecretKey()
    {
        return $this->_scopeConfig->getValue('auderecommerce_recaptcha/general/secret_key');
    }

}