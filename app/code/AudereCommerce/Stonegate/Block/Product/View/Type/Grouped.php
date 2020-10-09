<?php

namespace AudereCommerce\Stonegate\Block\Product\View\Type;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\Currency;

class Grouped extends \Magento\GroupedProduct\Block\Product\View\Type\Grouped
{

    protected $_attributeGroupCollection = null;
    /* @var $_attributeGroupCollection \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\Collection */
    protected $_productAttributeCollection = null;
    /* @var $_productAttributeCollection \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection */

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Currency
     */
    protected $_currency;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        array $data = [],
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\Collection $attributeGroupCollection,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $productAttributeCollection,
        Currency $currency
    )
    {
        parent::__construct($context, $arrayUtils, $data);
        $this->_attributeGroupCollection = $attributeGroupCollection;
        $this->_productAttributeCollection = $productAttributeCollection;
        $this->_storeManager = $context->getStoreManager();
        $this->_currency = $currency;
    }

    public function getProductAttributeValue(\Magento\Catalog\Model\Product $product, $attributeCode)
    {
        foreach ($this->_productAttributeCollection as $productAttribute) {
            /* @var $productAttribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
            if ($productAttribute->getAttributeCode() == $attributeCode) {
                $rawValue = $product->getResource()->getAttributeRawValue($product->getId(), $attributeCode, $this->_storeManager->getStore());

				if(is_array($rawValue)) {
					$rawValue	= implode(',', $rawValue);
				}
                if ($productAttribute->usesSource()) {
                    $attributeValue = $productAttribute->getSource()->getOptionText($rawValue);
                } else {
                    $attributeValue = $rawValue;
                }

                if(is_array($attributeValue)) {
                    return implode(',', $attributeValue);
                } else {
                    return $attributeValue;
                }
            }
        }

        return null;
    }

    public function getFrontendGroupedAttributes(\Magento\Catalog\Model\Product $product)
    {
        //get attribute set
        $attributeSetId = $product->getAttributeSetId();
        $this->_attributeGroupCollection->setAttributeSetFilter($attributeSetId);
        $this->_attributeGroupCollection->addFieldToFilter('attribute_group_name', 'Frontend');
        $attributeGroup = $this->_attributeGroupCollection->getFirstItem();
        $this->_productAttributeCollection->setAttributeGroupFilter($attributeGroup->getId());
        $this->_productAttributeCollection->setOrder('sort_order', 'ASC');

        $frontendGroupedAttributes = array();

        foreach ($this->_productAttributeCollection as $productAttribute) {
            /* @var $productAttribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
            $frontendGroupedAttributes[$productAttribute->getAttributeCode()] = $productAttribute->getFrontend()->getLabel();
        }

        return $frontendGroupedAttributes;
    }

    /**
     * @return string
     */
    public function getCurrentCurrencySymbol()
    {

        $store = $this->_storeManager->getStore();
        $currency = $store->getCurrentCurrency();

        $symbol = $currency->getCurrencySymbol();

        return $currency->getCurrencySymbol();
//        return $this->_currency->getCurrencySymbol();
    }

}
