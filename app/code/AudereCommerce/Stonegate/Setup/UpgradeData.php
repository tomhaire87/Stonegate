<?php

namespace AudereCommerce\Stonegate\Setup;

use \Magento\Eav\Setup\EavSetup;
use \Magento\Eav\Setup\EavSetupFactory;
use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface
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
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $eavSetup = $this->_eavSetupFactory->create(array('setup' => $setup));
            /* @var $eavSetup EavSetup */

            $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'is_top_level', array(
                'type' => 'int',
                'label' => 'Top Level',
                'input' => 'select',
                'source_model' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'required' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'General Information'
            ));
        }

        $setup->endSetup();
    }
}