<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model;

use Magento\Framework\Model\AbstractModel;
use AudereCommerce\AccountsIntegration\Api\AccountManagementInterface;
use AudereCommerce\AccountsIntegration\Api\Data\AccountInterface;

class Account extends AbstractModel implements AccountInterface
{

    const AVAILABLE_BALANCE = 'available_balance';

    const CODE = 'code';

    const PRICE_LIST = 'price_list';

    const CUSTOMER_GROUP_ID = 'customer_group_id';

    const ID = 'id';

    /**
     * @var AccountManagementInterface
     */
    protected $_accountManagementInterface;

    /**
     * @param AccountManagementInterface $accountManagementInterface
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(AccountManagementInterface $accountManagementInterface, \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->_accountManagementInterface = $accountManagementInterface;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init('AudereCommerce\AccountsIntegration\Model\ResourceModel\Account');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->setData(self::ID, (int)$id);
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->setData(self::CODE, (string)$code);
        return $this;
    }

    /**
     * @return string
     */
    public function getPriceList()
    {
        return $this->getData(self::PRICE_LIST);
    }

    /**
     * @param string $priceList
     * @return $this
     */
    public function setPriceList($priceList)
    {
        $this->setData(self::PRICE_LIST, (string)$priceList);
        return $this;
    }

    /**
     * @return int
     */
    public function getCustomerGroupId()
    {
        return $this->getData(self::CUSTOMER_GROUP_ID);
    }

    /**
     * @param int $customerGroupId
     * @return $this
     */
    public function setCustomerGroupId($customerGroupId)
    {
        $this->setData(self::CUSTOMER_GROUP_ID, (int)$customerGroupId);
        return $this;
    }

    /**
     * @return float
     */
    public function getAvailableBalance()
    {
        return $this->getData(self::AVAILABLE_BALANCE);
    }

    /**
     * @param float $availableBalance
     * @return $this
     */
    public function setAvailableBalance($availableBalance)
    {
        $this->setData(self::AVAILABLE_BALANCE, (float)$availableBalance);
        return $this;
    }

    /**
     * @return GroupSearchResultsInterface
     */
    public function getCustomerGroup()
    {
        return $this->_accountManagementInterface->getCustomerGroup($this);
    }
}