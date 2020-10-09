<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Observer;

use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer as Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Logger\Monolog;

class Payment implements ObserverInterface
{

    const PO_CODE = 'purchaseorder';

    /**
     * @var Monolog
     */
    protected $_logger;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var CustomerSession
     */
    protected $_customerSession;

    /**
     * @var CheckoutSession
     */
    protected $_checkoutSession;

    /**
     * @var GroupRepositoryInterface
     */
    protected $_groupRepository;

    /**
     * @var AccountRepositoryInterface
     */
    protected $_accountRepository;

    public function __construct(
        Monolog $logger,
        ScopeConfigInterface $scopeConfig,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        GroupRepositoryInterface $groupRepository,
        AccountRepositoryInterface $accountRepository
    )
    {
        $this->_logger = $logger;
        $this->_scopeConfig = $scopeConfig;
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_groupRepository = $groupRepository;
        $this->_accountRepository = $accountRepository;
    }

    public function execute(Observer $observer)
    {
        try {
            if ($observer->getMethodInstance()->getCode() == self::PO_CODE) {
                if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/order/po')) {
                    $observer->getResult()->setIsAvailable(false);

                    if ($this->_customerSession->isLoggedIn()) {
                        $customerGroupId = $this->_customerSession->getCustomerGroupId();
                        $customerGroup = $this->_groupRepository->getById($customerGroupId);
                        $account = $this->_accountRepository->getByCode($customerGroup->getCode());

                        if ($this->_checkoutSession->getQuote()->getGrandTotal() < $account->getAvailableBalance()) {
                            $observer->getResult()->setIsAvailable(true);
                        }
                    }
                }
            }
        } catch (NoSuchEntityException $exception) {

        } catch (\Exception $exception) {
            $this->_logger->addError($exception);
        }

        return $this;
    }
}