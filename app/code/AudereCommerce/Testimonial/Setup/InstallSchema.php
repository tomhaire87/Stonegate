<?php

namespace AudereCommerce\Testimonial\Setup;

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

        $testimonialTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_testimonial_testimonial'))
            ->addColumn('id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 10, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'ID')
            ->addColumn('name', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Name')
            ->addColumn('company', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => true
            ), 'Company')
            ->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Image')
            ->addColumn('testimonial', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Testimonial')
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
            ->setComment('Testimonial');

        $installer->getConnection()->createTable($testimonialTable);
    }
}