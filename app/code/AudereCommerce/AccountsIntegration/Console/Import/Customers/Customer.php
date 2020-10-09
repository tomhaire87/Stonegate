<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Console\Import\Customers;

use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use AudereCommerce\AccountsIntegration\Console\AbstractConsole;
use AudereCommerce\AccountsIntegration\Model\AccountFactory;
use AudereCommerce\KamarinEcommerceLink\Api\Upload\CustomerRepositoryInterface as KamarinCustomerRepositoryInterface;
use Magento\Customer\Api\AccountManagementInterface as MagentoAccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface as MagentoCustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\GroupInterfaceFactory;
use Magento\Customer\Api\GroupRepositoryInterface as MagentoGroupRepositoryInterface;
use Magento\Customer\Model\Data\AddressFactory as MagentoAddressFactory;
use Magento\Customer\Model\Data\CustomerFactory as MagentoCustomerFactory;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as GroupCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\State;
use Magento\Framework\Logger\Monolog;
use Magento\Framework\Registry;
use Magento\Store\Model\App\Emulation;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Customer extends AbstractConsole
{

    /**
     * @var Emulation
     */
    protected $_emulation;

    /**
     * @var State
     */
    protected $_state;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    protected $_searchCriteriaBuilderFactory;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var AccountRepositoryInterface
     */
    protected $_accountRepository;

    /**
     * @var AccountFactory
     */
    protected $_accountFactory;

    /**
     * @var KamarinCustomerRepositoryInterface
     */
    protected $_kamarinCustomerRepository;

    /**
     * @var MagentoCustomerRepositoryInterface
     */
    protected $_magentoCustomerRepository;

    /**
     * @var MagentoAccountManagementInterface
     */
    protected $_magentoAccountManagement;

    /**
     * @var MagentoCustomerFactory
     */
    protected $_magentoCustomerFactory;

    /**
     * @var MagentoAddressFactory
     */
    protected $_magentoAddressFactory;

    /**
     * @var MagentoGroupRepositoryInterface
     */
    protected $_magentoGroupRepository;

    /**
     * @var GroupCollectionFactory
     */
    protected $_groupCollectionFactory;

    /**
     * @var GroupInterfaceFactory
     */
    protected $_groupFactory;

    /**
     * @var Monolog
     */
    protected $_logger;

    /**
     * @var array
     */
    protected $_customerGroupIdsByCode = array();

    public function __construct(
        Emulation $emulation,
        State $state,
        ScopeConfigInterface $scopeConfig,
        Registry $registry,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        AccountRepositoryInterface $accountRepository,
        AccountFactory $accountFactory,
        KamarinCustomerRepositoryInterface $kamarinCustomerRepository,
        MagentoCustomerRepositoryInterface $magentoCustomerRepository,
        MagentoAccountManagementInterface $magentoAccountManagement,
        MagentoCustomerFactory $magentoCustomerFactory,
        MagentoAddressFactory $magentoAddressFactory,
        MagentoGroupRepositoryInterface $magentoGroupRepository,
        GroupCollectionFactory $groupCollectionFactory,
        GroupInterfaceFactory $groupFactory,
        Monolog $logger
    )
    {
        $this->_emulation = $emulation;
        $this->_state = $state;
        $this->_scopeConfig = $scopeConfig;
        $this->_registry = $registry;
        $this->_searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->_accountRepository = $accountRepository;
        $this->_accountFactory = $accountFactory;
        $this->_kamarinCustomerRepository = $kamarinCustomerRepository;
        $this->_magentoCustomerRepository = $magentoCustomerRepository;
        $this->_magentoAccountManagement = $magentoAccountManagement;
        $this->_magentoCustomerFactory = $magentoCustomerFactory;
        $this->_magentoAddressFactory = $magentoAddressFactory;
        $this->_magentoGroupRepository = $magentoGroupRepository;
        $this->_groupCollectionFactory = $groupCollectionFactory;
        $this->_groupFactory = $groupFactory;
        $this->_logger = $logger;

        parent::__construct('auderecommerce:accountsintegration:import:customers:customer');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return $this
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        try {
            $this->_state->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->_state->setAreaCode(\Magento\Backend\App\Area\FrontNameResolver::AREA_CODE);
        }

        if (!$this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/account')) {
            $this->log("Account import/update is not enabled");
        } else {
            $searchCriteria = $this->_searchCriteriaBuilderFactory
                ->create()
                ->addFilter('record_updated', 1)
                ->create();

            $searchResults = $this->_kamarinCustomerRepository->getList($searchCriteria);
            $kamarinCustomers = $searchResults->getItems();

            $kamarinCustomersCount = count($kamarinCustomers);
            $currentRecord = 0;

            if ($kamarinCustomersCount <= 0) {
                $this->log("No customers to import");
            } else {
                $this->log("Importing {$kamarinCustomersCount} customers");

                if (!$this->_registry->registry('disable_account_email')) {
                    $this->_registry->register('disable_account_email', true);
                }

                $customerGroups = $this->_groupCollectionFactory->create()->toOptionArray();

                foreach ($customerGroups as $customerGroup) {
                    $this->_customerGroupIdsByCode[$customerGroup['label']] = $customerGroup['value'];
                }

                $emailField = $this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/email_field');

                foreach ($searchResults->getItems() as $kamarinCustomer) {
                    $currentRecord++;
                    $this->log("Customer {$currentRecord}/{$kamarinCustomersCount} (Account: {$kamarinCustomer->getAccountCode()})");

                    try {
                        $this->_importAndUpdate($kamarinCustomer, $emailField);

                        $kamarinCustomer->setRecordUpdated(0);
                        $this->_kamarinCustomerRepository->save($kamarinCustomer);
                    } catch (\Exception $exception) {
                        $this->log($exception);
                        $this->_logger->addError($exception);
                    }
                }

                $this->_registry->unregister('disable_account_email');
            }
        }

        return $this;
    }

    protected function _importAndUpdate($kamarinCustomer, $emailField)
    {
        if (!$kamarinCustomer->getOnStop()) {
			$customer	= null;
            try {
                if ($email = $kamarinCustomer->getData($emailField)) {
                    $customer = $this->_magentoCustomerRepository->get($email);
                }
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $customer = $this->_importCustomer($kamarinCustomer, $email);
            }

            if ($customer instanceof CustomerInterface && $this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/link')) {
                $this->_updateCustomer($kamarinCustomer, $customer);
            } else {
                $this->_createOrUpdateAccount($kamarinCustomer);
            }
        }
    }

    protected function _importCustomer($kamarinCustomer, $email)
    {
        if ($this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/import')) {
            $customer = $this->_magentoCustomerFactory->create();
            $customer->setFirstname($kamarinCustomer->getName());
            $customer->setLastname($kamarinCustomer->getAccountCode());
            $customer->setEmail($email);

            $this->_createOrUpdateAccount($kamarinCustomer, $customer);

            $address = $this->_magentoAddressFactory->create();
            $address->setCompany($kamarinCustomer->getName());
            $address->setFirstname($kamarinCustomer->getName());
            $address->setLastname($kamarinCustomer->getAccountCode());
            $address->setStreet([$kamarinCustomer->getAddress1(), $kamarinCustomer->getAddress2()]);
            $address->setCity($kamarinCustomer->getAddress3() ? $kamarinCustomer->getAddress3() : 'N/A');
            $address->setPostcode($kamarinCustomer->getPostcode() ? $kamarinCustomer->getPostcode() : 'N/A');

            if ($vatRegNumber = $kamarinCustomer->getVatRegNumber()) {
                $countryId = substr($vatRegNumber, 0, 2);
                $address->setVatId($vatRegNumber);
            } else {
                $countryId = 'GB';
            }

            $address->setCountryId($countryId);
            $address->setTelephone($kamarinCustomer->getTelephoneNumber());
            $address->setFax($kamarinCustomer->getFaxNumber());
            $address->setIsDefaultBilling(true);
            $address->setIsDefaultShipping(true);
            $customer->setAddresses([$address]);

            $savedCustomer = $this->_magentoAccountManagement->createAccount($customer);

            return $savedCustomer;
        }

        return false;
    }

    protected function _updateCustomer($kamarinCustomer, $customer)
    {
        $this->_createOrUpdateAccount($kamarinCustomer, $customer);
        $this->_magentoCustomerRepository->save($customer);

        return $customer;
    }

    protected function _createOrUpdateAccount($kamarinCustomer, $customerToLink = null)
    {
        $customerGroupCode = $kamarinCustomer->getAccountCode();

        if (!isset($this->_customerGroupIdsByCode[$customerGroupCode])) {
            $customerGroup = $this->_groupFactory
                ->create()
                ->setCode($customerGroupCode)
                ->setTaxClassId($this->_scopeConfig->getValue('auderecommerce_accountsintegration/customer/default_tax_class'));

            $customerGroup = $this->_magentoGroupRepository->save($customerGroup);
            $this->_customerGroupIdsByCode[$customerGroupCode] = $customerGroup->getId();
        }

        if ($customerToLink && $customerToLink->getGroupId() !== $this->_customerGroupIdsByCode[$customerGroupCode]) {
            $customerToLink->setGroupId($this->_customerGroupIdsByCode[$customerGroupCode]);
        }

        $priceListCode = $kamarinCustomer->getPriceListCode();

        try {
            $account = $this->_accountRepository->getByCode($customerGroupCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $account = $this->_accountFactory
                ->create()
                ->setCode($customerGroupCode)
                ->setCustomerGroupId($this->_customerGroupIdsByCode[$customerGroupCode]);
        }

        $availableBalance = max(0, $kamarinCustomer->getCreditLimit() - $kamarinCustomer->getAccountBalance());
        $account->setAvailableBalance($availableBalance);

        if ($priceListCode && $account->getPriceList() !== $priceListCode) {
            $account->setPriceList($priceListCode);
        }

        $this->_accountRepository->save($account);
    }

}