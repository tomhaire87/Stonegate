<?php

namespace Affinity\Stonegate\Setup;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

/**
 * {@inheritDoc}
 */
class UpgradeData implements UpgradeDataInterface
{
	/**
	 * @var CategorySetupFactory
	 */
	private $_categorySetupFactory;

	/**
	 * Constructor
	 * @param CategorySetupFactory $categorySetupFactory
	 */
	public function __construct(
		CategorySetupFactory $categorySetupFactory
	)
	{
		$this->_categorySetupFactory	= $categorySetupFactory;
	}

	/**
	 * {@inheritDoc}
	 * @param  ModuleDataSetupInterface $setup
	 * @param  ModuleContextInterface   $context
	 */
	public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$setup->startSetup();
		if(version_compare($context->getVersion(), '1.0.0') < 0) {
			$this->_addOnHomepageAttributeToCategory($setup);
		}
		if(version_compare($context->getVersion(), '1.0.1') < 0) {
			$this->_addOnHomepagePositionAttributeToCategory($setup);
		}
		$setup->endSetup();
	}

	/**
	 * Add "on_homepage_position" attribute to category EAV data
	 *
	 * Used for positioning categories on homepage
	 *
	 * @param  ModuleDataSetupInterface $setup
	 * @return UpgradeData
	 */
	protected function _addOnHomepagePositionAttributeToCategory(ModuleDataSetupInterface $setup) : UpgradeData
	{
		/** @var CategorySetup $categorySetup */
		$categorySetup		= $this->_categorySetupFactory->create(['setup' => $setup]);
		$entityTypeId		= $categorySetup->getEntityTypeId(Category::ENTITY);
		$attributeSetId		= $categorySetup->getDefaultAttributeSetId($entityTypeId);
		$attributeGroupId	= $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');
		$attributeKey		= 'on_homepage_position';
		$categorySetup->addAttribute(Category::ENTITY, $attributeKey, [
			'type'		=> 'varchar',
			'label'		=> 'On Hompeage Position',
			'input'		=> 'text',
			'required'	=> false,
			'global'	=> ScopedAttributeInterface::SCOPE_STORE,
			'group'		=> 'General Information'
		]);
		$categorySetup->addAttributeToGroup(
			$entityTypeId,
			$attributeSetId,
			$attributeGroupId,
			$attributeKey,
			6
		);

		return $this;
	}

	/**
	 * Add "on_homepage" attribute to category EAV data
	 *
	 * Used for assigning categories to homepage
	 * category blocks
	 *
	 * @param ModuleDataSetupInterface $setup
	 * @return UpgradeData
	 */
	protected function _addOnHomepageAttributeToCategory(ModuleDataSetupInterface $setup) : UpgradeData
	{
		/** @var CategorySetup $categorySetup */
		$categorySetup		= $this->_categorySetupFactory->create(['setup' => $setup]);
		$entityTypeId		= $categorySetup->getEntityTypeId(Category::ENTITY);
		$attributeSetId		= $categorySetup->getDefaultAttributeSetId($entityTypeId);
		$attributeGroupId	= $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'General Information');
		$attributeKey		= 'on_homepage';
		$categorySetup->addAttribute(Category::ENTITY, $attributeKey, [
			'type'			=> 'int',
			'label'			=> 'On Homepage',
			'input'			=> 'select',
			'source_model'	=> 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
			'required'		=> false,
			'global'		=> ScopedAttributeInterface::SCOPE_STORE,
			'group'			=> 'General Information'
		]);
		$categorySetup->addAttributeToGroup(
			$entityTypeId,
			$attributeSetId,
			$attributeGroupId,
			$attributeKey,
			5
		);

		return $this;
	}
}