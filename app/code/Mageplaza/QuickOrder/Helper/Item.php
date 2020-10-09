<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_QuickOrder
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\QuickOrder\Helper;

use Magento\Catalog\Model\Config;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Item
 * @package Mageplaza\QuickOrder\Helper
 */
class Item extends Data
{
    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $productVisibility;

    /**
     * @var \Magento\Catalog\Model\Config
     */
    protected $catalogConfig;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $_priceHelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productRepository;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\StockItemRepository
     */
    protected $_stockItemRepository;

    /**
     * Item constructor.
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ObjectManagerInterface $objectManager
     * @param Session $customerSession
     * @param HttpContext $httpcontext
     * @param PricingHelper $priceHelper
     * @param Visibility $catalogProductVisibility
     * @param Config $catalogConfig
     * @param ProductFactory $productFactory
     * @param ProductRepository $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param StockItemRepository $stockItemRepository
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ObjectManagerInterface $objectManager,
        Session $customerSession,
        HttpContext $httpcontext,
        PricingHelper $priceHelper,
        Visibility $catalogProductVisibility,
        Config $catalogConfig,
        ProductFactory $productFactory,
        ProductRepository $productRepository,
        PriceCurrencyInterface $priceCurrency,
        StockItemRepository $stockItemRepository
    )
    {
        $this->_priceHelper         = $priceHelper;
        $this->productVisibility    = $catalogProductVisibility;
        $this->catalogConfig        = $catalogConfig;
        $this->_productFactory      = $productFactory;
        $this->_productRepository   = $productRepository;
        $this->priceCurrency        = $priceCurrency;
        $this->_stockItemRepository = $stockItemRepository;

        parent::__construct($context, $objectManager, $storeManager, $customerSession, $httpcontext);
    }

    /**
     * @return mixed
     */
    public function getMediaHelper()
    {
        return $this->objectManager->get(Media::class);
    }

    /**
     * @param $sku
     * @param $store
     * @param $group
     * @return Collection
     */
    public function getProductCollectionForStore($sku, $store, $group)
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->objectManager->create(Collection::class);
        $collection->addAttributeToSelect($this->catalogConfig->getProductAttributes())
            ->setStore($store)
            ->addPriceData($group)
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite();

        $collection->addAttributeToFilter('sku', $sku);
        $collection->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);

        return $collection;
    }

    /**
     * @param $productId
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductAttributeOptions($productId)
    {
        $product                 = $this->_productRepository->getById($productId);
        $productAttribute        = $this->objectManager->get('Magento\ConfigurableProduct\Model\Product\Type\Configurable');
        $productAttributeOptions = $productAttribute->getConfigurableAttributesAsArray($product);

        return $productAttributeOptions;
    }

    /**
     * @param $code
     * @param $attributeOption
     * @return bool
     */
    public function checkAttributeCode($code, $attributeOption)
    {
        $attrCode = [];
        foreach ($attributeOption as $op) {
            $attrCode[] = $op['attribute_code'];
        }

        if (is_array($attrCode) && isset($attrCode)) {
            if (in_array($code, $attrCode)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $code
     * @param $attributeOption
     * @return string
     */
    public function getcheckAttributeCodeId($code, $attributeOption)
    {
        $attrCodeId = '';
        foreach ($attributeOption as $op) {
            if ($op['attribute_code'] == $code) {
                $attrCodeId = $op['attribute_id'];
            }
        }

        return $attrCodeId;
    }

    /**
     * @param $value
     * @param $attributeOption
     * @return bool
     */
    public function checkValueOfAttributeCode($value, $attributeOption)
    {
        $attrCodeValues = [];
        $values         = [];
        foreach ($attributeOption as $op) {
            $attrCodeValues[] = $op['values'];
        }

        foreach ($attrCodeValues as $key => $val) {
            foreach ($val as $cv) {
                $values[] = $cv['store_label'];
            }
        }

        if (is_array($values) && isset($values)) {
            if (in_array($value, $values)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $value
     * @param $attributeOption
     * @return string
     */
    public function getcheckIdValueOfAttributeCode($value, $attributeOption)
    {
        $attrCodeValues = [];
        $valueId        = '';
        foreach ($attributeOption as $op) {
            $attrCodeValues[] = $op['values'];
        }

        foreach ($attrCodeValues as $key => $val) {
            foreach ($val as $cv) {
                if ($value == $cv['store_label']) {
                    $valueId = $cv['value_index'];
                }
            }
        }

        return $valueId;
    }

    /**
     * @param $productId
     * @param $productName
     * @param $sku
     * @param $skuChild
     * @param $qty
     * @param $getFinalPrice
     * @param $store
     * @param $typeId
     * @param $options
     * @param $optionIds
     * @param $optionSelectValue
     * @param $getSelectValueIdKey
     * @param $superAttribute
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPreItemDataArray($productId, $productName, $sku, $skuChild, $qty, $getFinalPrice, $store, $typeId, $options, $optionIds, $optionSelectValue, $getSelectValueIdKey, $superAttribute)
    {
        $preItem = [
            'item_id'                 => $this->generateRandomString(9),
            'product_id'              => $productId,
            'name'                    => $productName,
            'sku'                     => $sku,
            'sku_child'               => $skuChild,
            'qty'                     => $qty,
            'qtystock'                => $this->getProductQtyStock($skuChild, $productId),
            'price'                   => $this->priceCurrency->round($this->_priceHelper->currencyByStore($getFinalPrice, $store, false, false)),
            'imageUrl'                => $this->getProductImageUrl($productId, $store),
            'type_id'                 => $typeId,
            'porudct_url'             => $this->getProductUrl($productId),
            'options'                 => $options,
            'optionIds'               => $optionIds,
            'options_select_value'    => $optionSelectValue,
            'options_select_value_id' => $getSelectValueIdKey,
            'super_attribute'         => $superAttribute,
            'outofstock'              => $this->getProductOutofStock($productId)
        ];

        return $preItem;
    }

    /**
     * @param $length
     * @return string
     */
    public function generateRandomString($length = 4)
    {
        $characters       = '0123456789';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * @param $productId
     * @param $store
     * @return string
     */
    public function getProductImageUrl($productId, $store)
    {
        $prdoduct        = $this->_productFactory->create()->load($productId);
        $productImageUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $prdoduct->getImage();

        return $productImageUrl;
    }

    /**
     * @param $productId
     * @return string
     */
    public function getProductUrl($productId)
    {
        $product    = $this->_productFactory->create()->load($productId);
        $productUrl = $product->getProductUrl();

        return $productUrl;
    }

    /**
     * @param $productAttributeId
     * @param $productId
     * @return mixed
     */
    public function getchidrenSimpleProudctByAttribute($productAttributeId, $productId)
    {
        $product         = $this->_productFactory->create()->load($productId);
        $productChildren = $this->objectManager->create('Magento\ConfigurableProduct\Model\Product\Type\Configurable')
            ->getProductByAttributes($productAttributeId, $product);

        return $productChildren;
    }

    /**
     * @param $productId
     * @return bool|int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductOutofStock($productId)
    {
        $product          = $this->_stockItemRepository->get($productId);
        $productIsInStock = $product->getIsInStock();

        return $productIsInStock;
    }

    /**
     * @param $skuChild
     * @param $productId
     * @return float
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductQtyStock($skuChild, $productId)
    {
        if ($skuChild != '') {
            $productChildBySku = $this->_productRepository->get($skuChild);
            $productChildId    = $productChildBySku->getId();
            $product           = $this->_stockItemRepository->get($productChildId);
            $productQtyStock   = $product->getQty();

            return $productQtyStock;
        }

        $product         = $this->_stockItemRepository->get($productId);
        $productQtyStock = $product->getQty();

        return $productQtyStock;
    }

    /**
     * @param $sku
     * @param $qty
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPreItemNotMeetConditionsFilter($sku, $qty)
    {
        $product       = $this->_productRepository->get($sku);
        $productId     = $product->getId();
        $productName   = $product->getName();
        $getFinalPrice = $product->getFinalPrice();
        $typeId        = $product->getTypeId();
        $store         = $this->storeManager->getStore();

        if ($typeId != 'bundle' && $typeId != 'grouped') {
            $preItem = [
                'item_id'                 => $this->generateRandomString(9),
                'product_id'              => $productId,
                'name'                    => $productName,
                'sku'                     => $sku,
                'sku_child'               => '',
                'qty'                     => $qty,
                'qtystock'                => $this->getProductQtyStock($skuChild = '', $productId),
                'price'                   => $this->priceCurrency->round($this->_priceHelper->currencyByStore($getFinalPrice, $store, false, false)),
                'imageUrl'                => $this->getProductImageUrl($productId, $store),
                'type_id'                 => $typeId,
                'porudct_url'             => $this->getProductUrl($productId),
                'options'                 => '',
                'optionIds'               => '',
                'options_select_value'    => '',
                'options_select_value_id' => '',
                'super_attribute'         => '',
                'outofstock'              => $this->getProductOutofStock($productId)
            ];

            return $preItem;
        }
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getProductOptionDefaultValue($attributeOption)
    {
        $options = [];
        foreach ($attributeOption as $op) {
            $attrCode         = $op['attribute_code'];
            $attrCodeValues[] = $op['values'];
            foreach ($attrCodeValues as $key => $val) {
                foreach ($val as $cv) {
                    $valueDefaut = $cv['store_label'];
                    break;
                }
            }
            $options[] = $attrCode . ':' . $valueDefaut;
        }

        return $options;
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getSuperAttribute($attributeOption)
    {
        $options = [];
        foreach ($attributeOption as $op) {
            $attributeId = $op['attribute_id'];
            $attrCode    = $op['attribute_code'];
            $options[]   = $attributeId . ':' . $attrCode;
        }

        return $options;
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getOptionIdsDefaultValue($attributeOption)
    {
        $options = [];
        foreach ($attributeOption as $op) {
            $attrId         = $op['attribute_id'];
            $attrIdValues[] = $op['values'];
            foreach ($attrIdValues as $key => $val) {
                foreach ($val as $cv) {
                    $valueDefaut = $cv['value_index'];
                    break;
                }
            }
            $options[] = $attrId . ':' . $valueDefaut;
        }

        return $options;
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getOptionIdsDefaultParam($attributeOption)
    {
        $options = [];
        foreach ($attributeOption as $op) {
            $attrId         = $op['attribute_id'];
            $attrIdValues[] = $op['values'];
            foreach ($attrIdValues as $key => $val) {
                foreach ($val as $cv) {
                    $valueDefaut = $cv['value_index'];
                    break;
                }
            }
            $options += [$attrId => $valueDefaut];
        }

        return $options;
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getSelectValueDefault($attributeOption)
    {
        $optionSelect = [];
        foreach ($attributeOption as $op => $opval) {
            $label            = [];
            $attrCodeValues   = [];
            $attrCode         = $opval['attribute_code'];
            $attrCodeValues[] = $opval['values'];
            foreach ($attrCodeValues as $key => $val) {
                foreach ($val as $cv) {
                    $label[] = $cv['store_label'];
                }
            }

            $optionSelect[$attrCode] = $label;
            $store_label             = null;
        }

        return $optionSelect;
    }

    /**
     * @param $attributeOption
     * @return array
     */
    public function getSelectValueIdKey($attributeOption)
    {
        $optionSelect = [];
        foreach ($attributeOption as $op => $opval) {
            $label            = [];
            $attrCodeValues   = [];
            $attrCode         = $opval['attribute_code'];
            $attrCodeValues[] = $opval['values'];
            foreach ($attrCodeValues as $key => $val) {
                foreach ($val as $cv) {
                    $label[] = $cv['value_index'] . ':' . $cv['store_label'];
                }
            }

            $store_label             = implode(',', $label);
            $optionSelect[$attrCode] = explode(',', $store_label);
            $store_label             = null;
        }

        return $optionSelect;
    }

    /**
     * @param $attrcode
     * @param $valueOfAttrCode
     * @param $arrayConvert
     * @param $getSelectValueDefault
     * @return mixed
     */
    public function getSelectValueConvertOption($attrcode, $valueOfAttrCode, $arrayConvert, $getSelectValueDefault)
    {
        foreach ($getSelectValueDefault as $attribute => $values) {
            if ($attrcode == $attribute) {
                foreach ($values as $key => $value) {
                    if ($valueOfAttrCode == $value) {
                        unset($values[$key]);
                        array_unshift($values, $valueOfAttrCode);
                    }
                }
                $arrayConvert[$attribute] = $values;
            }
        }

        return $arrayConvert;
    }
}