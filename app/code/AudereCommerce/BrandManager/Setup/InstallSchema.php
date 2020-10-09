<?php

namespace AudereCommerce\BrandManager\Setup;

use \Magento\Framework\Setup\InstallSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;

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

        $brandTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_brandmanager_brand'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Name')
            ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, array(
                'nullable' => false
            ), 'description')
            ->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Image')
            ->addColumn('category_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false
            ), 'Category')
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ), 'Updated At')
            ->addForeignKey(
                $installer->getFkName(
                    'brand',
                    'category_id',
                    'category',
                    'entity_id'
                ),
                'category_id',
                $installer->getTable('catalog_category_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
            )
            ->setComment('Brand');

        $installer->getConnection()->createTable($brandTable);
    }
}