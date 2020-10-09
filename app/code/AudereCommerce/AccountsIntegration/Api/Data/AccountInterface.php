<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Api\Data;

use AudereCommerce\AccountsIntegration\Model\ResourceModel\Account;

interface AccountInterface
{

    const ENTITY_TYPE = 'account';

    /**
     * @return Account
     */
    public function getResource();

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getPriceList();

    /**
     * @param string $priceList
     * @return $this
     */
    public function setPriceList($priceList);

    /**
     * @return int
     */
    public function getCustomerGroupId();

    /**
     * @param int $customerGroupId
     * @return $this
     */
    public function setCustomerGroupId($customerGroupId);

    /**
     * @return float
     */
    public function getAvailableBalance();

    /**
     * @param float $availableBalance
     * @return $this
     */
    public function setAvailableBalance($availableBalance);

    /**
     * @return \Magento\Customer\Api\Data\GroupInterface
     */
    public function getCustomerGroup();

}