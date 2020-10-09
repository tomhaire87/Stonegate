<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */
namespace AudereCommerce\AccountsIntegration\Model\Framework\App;

class ResourceConnection extends \Magento\Framework\App\ResourceConnection
{
    public function getTableName($modelEntity, $connectionName = self::DEFAULT_CONNECTION)
    {
        if ($connectionName == 'kamarin_ecommerce_link') {
            $tableName = $modelEntity;
            return $this->getConnection($connectionName)->getTableName($tableName);
        } else {
            return parent::getTableName($modelEntity, $connectionName);
        }
    }
}