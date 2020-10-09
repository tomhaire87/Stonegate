<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use AudereCommerce\AccountsIntegration\Api\AccountRepositoryInterface;
use AudereCommerce\AccountsIntegration\Api\Data\AccountInterface;
use AudereCommerce\AccountsIntegration\Api\Data\AccountSearchResultsInterface;
use AudereCommerce\AccountsIntegration\Model\AccountFactory;
use AudereCommerce\AccountsIntegration\Model\ResourceModel\Account\CollectionFactory;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @var CollectionFactory
     */
    protected $_accountCollectionFactory;

    /**
     * @var AccountFactory
     */
    protected $_accountFactory;

    /**
     * @var AccountInterface[]
     */
    protected $_instancesById = array();

    /**
     * @var array
     */
    protected $_instanceIdsByCode = array();

    /**
     * @param CollectionFactory $accountCollectionFactory
     * @param AccountFactory $accountFactory
     */
    public function __construct(CollectionFactory $accountCollectionFactory, AccountFactory $accountFactory)
    {
        $this->_accountCollectionFactory = $accountCollectionFactory;
        $this->_accountFactory = $accountFactory;
    }

    /**
     * @param AccountInterface $account
     * @return AccountInterface
     */
    public function save(AccountInterface $account)
    {
        return $account->getResource()->save($account);
    }

    /**
     * @param int $id
     * @param bool $forceReload
     * @return AccountInterface
     */
    public function getById($id, $forceReload = false)
    {
        if (!isset($this->_instancesById[$id]) || $forceReload) {
            $model = $this->_accountFactory->create();
            $model->load($id);

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('id', $id);
            }

            $this->_instancesById[$id] = $model;
            $this->_instanceIdsByCode[$model->getCode()] = $id;
        }

        return $this->_instancesById[$id];
    }

    /**
     * @param string $code
     * @param bool $forceReload
     * @return AccountInterface
     */
    public function getByCode($code, $forceReload = false)
    {
        if (!isset($this->_instanceIdsByCode[$code]) || $forceReload) {
            $model = $this->_accountFactory->create();
            $model->load($code, 'code');

            if (!$model->getId()) {
                throw NoSuchEntityException::singleField('code', $code);
            }

            $this->_instancesById[$model->getId()] = $model;
            $this->_instanceIdsByCode[$code] = $model->getId();
        }

        return $this->_instancesById[$this->_instanceIdsByCode[$code]];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return AccountSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $accountCollection = $this->_accountCollectionFactory->create();
        $filterGroups = $searchCriteria->getFilterGroups();

        foreach ($filterGroups as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                $accountCollection->addFieldToFilter($filter->getField(), array($condition => $filter->getValue()));
            }
        }

        return $accountCollection;
    }

    /**
     * @param AccountInterface $account
     * @return bool
     */
    public function delete(AccountInterface $account)
    {
        $id = $account->getId();

        try {
            unset($this->_instancesById[$id]);
            $account->getResource()->delete($account);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\StateException(__('Unable to remove %1', $id));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id)
    {
        $model = $this->getById($id);
        return $this->delete($model);
    }
}