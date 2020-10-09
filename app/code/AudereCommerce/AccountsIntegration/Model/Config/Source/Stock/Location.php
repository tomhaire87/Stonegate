<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Stock;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ResourceConnection\ConfigInterface as ResourceConfigInterface;
use Magento\Framework\Option\ArrayInterface;

class Location implements ArrayInterface
{

    /**
     * @var ResourceConnection
     */
    protected $_resource;

    /**
     * @var ResourceConfigInterface
     */
    protected $_config;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        ResourceConfigInterface $config
    )
    {
        $this->_resource = $resourceConnection;
        $this->_config = $config;
    }

    public function toOptionArray()
    {
        if ($this->_config->getConnectionName('kamarin_ecommerce_link') === \Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION) {
            throw new \Exception('Unable to find the Kamarin Intermediate Tables');
        }

        $connection = $this->_resource->getConnection('kamarin_ecommerce_link');
        $table = $connection->getTableName('stock_locations');

        $select = $connection->select()->from($table);

        $options = array();

        foreach ($connection->fetchAll($select) as $location) {
            $options[] = array(
                'value' => $location['location_code'],
                'label' => $location['name']
            );
        }

        return $options;
    }

}
