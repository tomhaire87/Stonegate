<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $accountTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_accountsintegration_account'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('code', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false,
                'unique' => true
            ), 'Code')
            ->addColumn('price_list', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => true,
                'unique' => true
            ), 'Price List')
            ->addColumn('customer_group_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'unsigned' => true,
                'nullable' => false
            ), 'Customer Group ID')
            ->addColumn('available_balance', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,5', array(
                'default' => 0.00000,
                'nullable' => false
            ), 'Available Balance')
            ->setComment('Account');

        $installer->getConnection()->createTable($accountTable);
    }

}