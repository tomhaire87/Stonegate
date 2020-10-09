<?php

namespace AudereCommerce\BrandMAnager\Setup;

use \Magento\Eav\Setup\EavSetup;
use \Magento\Eav\Setup\EavSetupFactory;
use \Magento\Framework\Setup\InstallDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{

    protected $_eavSetupFactory;

    /**
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->_eavSetupFactory->create(array('setup' => $setup));
        /* @var $eavSetup EavSetup */

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'brand', array(
            'type' => 'int',
            'label' => 'Brand',
            'input' => 'select',
            'required' => false,
            'default' => '0',
            'source' => 'AudereCommerce\BrandManager\Model\Brand\Attribute\Source\Product',
            'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible_on_front' => true,
            'used_in_product_listing' => true
        ));
    }
}