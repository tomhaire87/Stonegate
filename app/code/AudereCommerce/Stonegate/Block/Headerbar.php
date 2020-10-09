<?php

namespace AudereCommerce\Stonegate\Block;

use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;

class Headerbar extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_session;

    /**
     * @var AccountRepositoryInterface
     */
    protected $_accountRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $session,
        AccountRepositoryInterface $accountRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
    )
    {
        parent::__construct($context);

        $this->_session = $session;
        $this->_accountRepository = $accountRepository;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
    }

    /**
     * Get session
     *
     * @return \Magento\Customer\Model\Session
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        return $this->getSession()->getCustomer();
    }

    /**
     * Get Account Code
     *
     * @return bool|string
     */
    public function getAccountCode()
    {
        $session = $this->getSession();

        if ($session->isLoggedIn()) {
            $customerGroupId = $session->getCustomerGroupId();

            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('customer_group_id', $customerGroupId)
                ->setPageSize(1)
                ->create();

            $accounts = $this->_accountRepository->getList($searchCriteria)->getItems();

            if (!empty($accounts)) {
                $account = reset($accounts);
                return $account->getCode();
            }
        }

        return false;
    }

    /**
     * Has Account Code
     *
     * @return bool
     */
    public function hasAccountCode()
    {
        return $this->getAccountCode() !== false;
    }

}
