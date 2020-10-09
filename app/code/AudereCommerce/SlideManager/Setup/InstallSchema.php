<?php

namespace AudereCommerce\SlideManager\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $sliderTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_slidemanager_slider'))
            ->addColumn('slider_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Slider ID')
            ->addColumn('identifier', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Identifier')
            ->addColumn('location', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Location')
            ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, array(
                'nullable' => false,
                'unsigned' => true,
                'default' => 0
            ), 'Status')
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Updated At')
            ->setComment('Slide Manager Slider Table');

        $slideTable = $installer->getConnection()
            ->newTable($installer->getTable('auderecommerce_slidemanager_slide'))
            ->addColumn('slide_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ), 'Slide ID')
            ->addColumn('slider_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => true,
            ), 'Slider ID')
            ->addColumn('identifier', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Identifier')
            ->addColumn('title', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => true
            ), 'Title')
            ->addColumn('title_colour', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => true
            ), 'Title Colour')
            ->addColumn('subtitle', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => true
            ), 'Subtitle')
            ->addColumn('subtitle_colour', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => true
            ), 'Subtitle Colour')
            ->addColumn('subtitle_position', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => true
            ), 'Subtitle Position')
            ->addColumn('content', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, array(
                'nullable' => true
            ), 'Content')
            ->addColumn('button_text', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 45, array(
                'nullable' => true
            ), 'Button Text')
            ->addColumn('button_text_colour', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => true
            ), 'Button Text Colour')
            ->addColumn('button_background_colour', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 50, array(
                'nullable' => true
            ), 'Button Background Colour')
            ->addColumn('link', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => true
            ), 'Link')
            ->addColumn('image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Image')
            ->addColumn('small_image', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 255, array(
                'nullable' => false
            ), 'Small Image')
            ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, array(
                'nullable' => false,
                'default' => 1
            ), 'Position')
            ->addColumn('created_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Created At')
            ->addColumn('updated_at', \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, null, array(
                'nullable' => false,
                'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ), 'Updated At')
            ->setComment('Slide Manager Slide Table');

        $installer->getConnection()->createTable($sliderTable);
        $installer->getConnection()->createTable($slideTable);

        $installer->endSetup();

    }
}