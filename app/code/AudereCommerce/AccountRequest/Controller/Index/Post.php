<?php

namespace AudereCommerce\AccountRequest\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Mail\Template\TransportBuilder;

class Post extends Action
{

    /**
     * @var RedirectFactory
     */
    protected $_resultRedirectFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @param Context $context
     * @param RedirectFactory $resultRedirectFactory
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     */
    function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder
    )
    {
        $this->_resultRedirectFactory = $context->getResultRedirectFactory();
        $this->_storeManager = $storeManager;
        $this->_logger = $logger;
        $this->_scopeConfig = $scopeConfig;
        $this->_transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->_resultRedirectFactory->create();

        if (!$this->getRequest()->isPost()) {
            return $resultRedirect->setPath('requesttrade');
        }

        try {
            $store = $this->_storeManager->getStore();

            $transport = $this->_transportBuilder->setTemplateIdentifier('accountrequest_request_email_template')
                ->setTemplateOptions(array(
                    'area' => 'frontend',
                    'store' => $store->getId()
                ))
                ->setTemplateVars(array(
                    'store' => $store,
                    'params' => $this->getRequest()->getParams()
                ))
                ->setFrom(array('email' => $this->_scopeConfig->getValue('auderecommerce_accountrequest/general/email', 'store', $store->getId()), 'name' => 'Trade Account Request'))
                ->addTo($this->_scopeConfig->getValue('auderecommerce_accountrequest/general/email', 'store', $store->getId()))
                ->getTransport();

            $transport->sendMessage();
            return $resultRedirect->setPath('requesttrade/success');

        } catch (\Magento\Framework\Exception\MailException $e) {
            $this->_logger->critical($e);
        } catch (\Exception $e) {
            $this->_logger->critical($e);
        }

        $this->messageManager->addErrorMessage(__('Unable to request Trade Account.'));
        return $resultRedirect->setPath('requesttrade');
    }

}
