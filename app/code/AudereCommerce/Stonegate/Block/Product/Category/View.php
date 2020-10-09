<?php

namespace AudereCommerce\Stonegate\Block\Product\Category;

class View extends \Magento\Catalog\Block\Category\View
{

    protected $_categoryView = null;
    protected $_category = null;
    
    public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            \Magento\Catalog\Model\Layer\Resolver $layerResolver,
            \Magento\Framework\Registry $registry,
            \Magento\Catalog\Helper\Category $categoryHelper,
            array $data = [],
            \Magento\Catalog\Block\Category\View $categoryView,
            \Magento\Catalog\Model\Category $category
        )
    {
        parent::__construct($context, $layerResolver, $registry, $categoryHelper, $data);
        $this->_categoryView = $categoryView;
        $this->_category = $category;
    }
    
    public function getChildCategories()
    {
        $childCategories = $this->_categoryView->getCurrentCategory()->getChildrenCategories();
        return $childCategories;
    }

}
