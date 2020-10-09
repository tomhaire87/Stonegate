<?php

namespace AudereCommerce\Stonegate\Block;

class Categories extends \Magento\Framework\View\Element\Template
{

    protected $_categoryHelper = null;
    protected $_productCollection = null;
    protected $_productVisibility = null;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context, array $data = [],
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollection,
        \Magento\Catalog\Model\Product\Visibility $productVisibility
    )
    {
        parent::__construct($context, $data);
        $this->_categoryHelper = $categoryHelper;
        $this->_productCollection = $productCollection;
        $this->_productVisibility = $productVisibility;
    }


    public function getCategoryCollection()
    {
        $storeCategories = $this->_categoryHelper->getStoreCategories(false, true, false);
        /* @var $storeCategories Magento\Catalog\Model\ResourceModel\Category\Collection */
        $storeCategories->addLevelFilter(2);
        $storeCategories->addAttributeToSort('position');
        return $storeCategories;
    }
}
