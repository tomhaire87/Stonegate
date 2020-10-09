<?php

namespace Affinity\Stonegate\Block\Category;

class Featured extends \Magento\Framework\View\Element\Template
{

	/**
	 * Limit of featured categories to collect
	 * @var int
	 */
	const FEATURED_CATEGORY_LIMIT	= 5;

	/**
	 * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
	 */
	protected $_categoryCollectionFactory;

	/**
	 * @var \Magento\Catalog\Model\ResourceModel\Category\Attribute\Collection
	 */
	protected $_categoryAttributeCollection;

	/**
	 * @var \Magento\Framework\App\ResourceConnection
	 */
	protected $_resourceConnection;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context                   $context
	 * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory    $categoryCollectionFactory
	 * @param \Magento\Catalog\Model\ResourceModel\Category\Attribute\Collection $categoryAttributeCollection
	 * @param \Magento\Framework\App\ResourceConnection                          $resourceConnection
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
		\Magento\Catalog\Model\ResourceModel\Category\Attribute\Collection $categoryAttributeCollection,
		\Magento\Framework\App\ResourceConnection $resourceConnection
	)
	{
		parent::__construct($context);
		$this->_categoryCollectionFactory	= $categoryCollectionFactory;
		$this->_categoryAttributeCollection	= $categoryAttributeCollection;
		$this->_resourceConnection			= $resourceConnection;
	}

	/**
	 * Get collection of featured categories
	 * defined by attribute "is_featured"
	 *
	 * @return \Magento\Catalog\Model\ResourceModel\Category\Collection Featured Category Collection
	 */
	public function getFeaturedCategoryCollection()
	{
		$collection	= $this->_categoryCollectionFactory->create();
		$collection->addAttributeToSelect('*');
		$collection->addAttributeToFilter('on_homepage', true);
		$collection->addAttributeToSort('on_homepage_position');
		$collection->setPageSize(self::FEATURED_CATEGORY_LIMIT);
		$collection->setCurPage(1);
		return $collection;
	}
}