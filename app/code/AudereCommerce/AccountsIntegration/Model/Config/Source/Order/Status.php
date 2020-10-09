<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Order;

use Magento\Framework\Option\ArrayInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory as OrderStatusCollectionFactory;

class Status implements ArrayInterface
{

    /**
     * @var OrderStatusCollectionFactory
     */
    protected $_orderStatusCollectionFactory;

    /**
     * @param OrderStatusCollectionFactory $orderStatusCollectionFactory
     */
    public function __construct(OrderStatusCollectionFactory $orderStatusCollectionFactory)
    {
       $this->_orderStatusCollectionFactory = $orderStatusCollectionFactory;
    }

    /**
     * Get option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $orderStatusCollection = $this->_orderStatusCollectionFactory->create();
        $options = array();

        foreach ($orderStatusCollection as $orderStatus) {
            $options[] = array(
                'value' => $orderStatus->getStatus(),
                'label' => $orderStatus->getLabel()
            );
        }

        return $options;
    }

}
