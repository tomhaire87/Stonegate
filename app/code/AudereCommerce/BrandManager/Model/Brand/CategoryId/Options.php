<?php

namespace AudereCommerce\BrandManager\Model\Brand\CategoryId;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{

    /**
     * @var CategoryCollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * @var array
     */
    protected $_options;

    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $_categoryRepository;

    /**
     * @param CategoryCollectionFactory $categoryCollectionFactory
     */
    public function __construct(CategoryCollectionFactory $categoryCollectionFactory, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository)
    {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options == null) {
            $collection = $this->_categoryCollectionFactory->create();
            $collection->addAttributeToSelect('name');

            $rootCategory = $this->_categoryRepository->get(\Magento\Catalog\Model\Category::TREE_ROOT_ID);
            $options = $this->_getChildrenOptions($rootCategory);

//            foreach ($collection as $category) {
//                /* @var $category \Magento\Catalog\Model\Category */
//
//                $options[] = array(
//                    'value' => $category->getId(),
//                    'label' => $category->getPath()
//                );
//            }

            $this->_options = $options;
        }

        return $this->_options;
    }

    /**
     * @param \Magento\Catalog\Api\Data\CategoryInterface $tree
     * @param string $prefix
     * @param array $data
     * @return array
     */
    protected function _getChildrenOptions($tree, $prefix = '', &$data = array())
    {
        foreach ($tree->getChildrenCategories() as $child) {
            $name = ($prefix == '') ? $child->getName() : implode(' > ', array($prefix, $child->getName()));

            $data[] = array(
                'value' => $child->getId(),
                'label' => $name
            );

            if ($child->hasChildren()) {
                $this->_getChildrenOptions($child, $name, $data);
            }
        }

        return $data;
    }

}