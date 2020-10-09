<?php

namespace AudereCommerce\Downloads\Setup;

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

        $downloadTypeTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_downloads_download_type'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Name')
            ->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Image')
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ), 'Updated At')
            ->setComment('Download Type');

        $installer->getConnection()->createTable($downloadTypeTable);

        $downloadGroupTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_downloads_download_group'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Name')
            ->addColumn('url_key', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'URL Key')
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE
            ), 'Updated At')
            ->setComment('Download Group');

        $installer->getConnection()->createTable($downloadGroupTable);

        $downloadTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_downloads_download'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Name')
            ->addColumn('type_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false
            ), 'Type')
            ->addColumn('group_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false
            ), 'Group')
            ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'File Path')
            ->addColumn('active', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, array(
                'default' => 0,
                'nullable' => false
            ), 'Active')
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
                    'download',
                    'type_id',
                    'download_type',
                    'id'
                ),
                'type_id',
                $installer->getTable('auderecommerce_downloads_download_type'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
            )
            ->addForeignKey(
                $installer->getFkName(
                    'download',
                    'group_id',
                    'download_group',
                    'id'
                ),
                'group_id',
                $installer->getTable('auderecommerce_downloads_download_group'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
            )
            ->setComment('Download');

        $installer->getConnection()->createTable($downloadTable);

        $downloadCatalogProductEntityTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_downloads_download_product'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array('identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true), 'id')
            ->addColumn('download_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array('nullable' => false, 'unsigned' => true), 'download_id')
            ->addColumn('catalog_product_entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array('nullable' => false, 'unsigned' => true), 'catalog_product_entity_id')
            ->addForeignKey(
                $installer->getFkName(
                    'auderecommerce_downloads_download_product',
                    'download_id',
                    'auderecommerce_downloads_download',
                    'id'
                ),
                'download_id',
                $installer->getTable('auderecommerce_downloads_download'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
            )
            ->addForeignKey(
                $installer->getFkName(
                    'auderecommerce_downloads_download_product',
                    'catalog_product_entity_id',
                    'catalog_product_entity',
                    'entity_id'
                ),
                'catalog_product_entity_id',
                $installer->getTable('catalog_product_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_NO_ACTION
            )
            ->setComment('Download Product relationship');

        $installer->getConnection()->createTable($downloadCatalogProductEntityTable);
    }
}