<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Customer;

use Magento\Framework\Option\ArrayInterface;

class TaxClass implements ArrayInterface
{

    /**
     * @var \Magento\Tax\Model\ResourceModel\TaxClass\CollectionFactory
     */
    protected $_taxClassCollectionFactory;

    public function __construct(
        \Magento\Tax\Model\ResourceModel\TaxClass\CollectionFactory $taxClassCollectionFactory
    )
    {
        $this->_taxClassCollectionFactory = $taxClassCollectionFactory;
    }

    public function toOptionArray()
    {
        $options = $this->_taxClassCollectionFactory
            ->create()
            ->setClassTypeFilter(\Magento\Tax\Model\ClassModel::TAX_CLASS_TYPE_CUSTOMER)
            ->toOptionArray();

        return $options;
    }

}
