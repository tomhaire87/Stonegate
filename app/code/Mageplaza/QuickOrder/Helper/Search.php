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

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Config;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Escaper;
use Magento\Framework\Locale\FormatInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Search\Model\Product\Url;

/**
 * Class Search
 * @package Mageplaza\QuickOrder\Helper
 */
class Search extends Data
{
    const CONFIG_MODULE_PATH = 'quickorder';

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
     * @var \Magento\Framework\Escaper
     */
    protected $_escaper;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\CollectionFactory
     */
    protected $_customerGroupFactory;

    /**
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $localeFormat;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * Search constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Http\Context $httpcontext
     * @param \Magento\Customer\Model\ResourceModel\Group\CollectionFactory $customerGroupCollectionFactory
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\Pricing\Helper\Data $priceHelper
     * @param \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility
     * @param \Magento\Catalog\Model\Config $catalogConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ObjectManagerInterface $objectManager,
        Session $customerSession,
        HttpContext $httpcontext,
        CollectionFactory $customerGroupCollectionFactory,
        Escaper $escaper,
        PricingHelper $priceHelper,
        Visibility $catalogProductVisibility,
        Config $catalogConfig,
        FormatInterface $localeFormat,
        CategoryFactory $categoryFactory
    )
    {
        $this->_customerGroupFactory = $customerGroupCollectionFactory;
        $this->_escaper              = $escaper;
        $this->_priceHelper          = $priceHelper;
        $this->productVisibility     = $catalogProductVisibility;
        $this->catalogConfig         = $catalogConfig;
        $this->localeFormat          = $localeFormat;
        $this->categoryFactory       = $categoryFactory;

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
     * Create json file to contain product data
     */
    public function createJsonFile()
    {
        $errors         = [];
        $customerGroups = $this->_customerGroupFactory->create();
        foreach ($this->storeManager->getStores() as $store) {
            foreach ($customerGroups as $group) {
                try {
                    $this->createJsonFileForStore($store, $group->getId());
                } catch (\Exception $e) {
                    $errors[] = __('Cannot generate data for store %1 and customer group %2, %3', $store->getCode(), $group->getCode(), $e->getMessage());
                }
            }
        }

        return $errors;
    }

    /**
     * @param $store
     * @param $group
     * @return $this
     */
    public function createJsonFileForStore($store, $group)
    {
        $productList = [];

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->objectManager->create(Collection::class);
        $collection->addAttributeToSelect($this->catalogConfig->getProductAttributes())
            ->setStore($store)
            ->addPriceData($group)
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite()
            ->setVisibility($this->productVisibility->getVisibleInSearchIds());

        /** @var \Magento\Catalog\Model\Product $product */
        foreach ($collection as $product) {
            $finalPrice = $product->getFinalPrice();
            if ($product->getTypeId() == 'configurable') {
                $_children = $product->getTypeInstance()->getUsedProducts($product);
                foreach ($_children as $child) {
                    $finalPrice = $child->getFinalPrice();
                    break;
                }
            }

            $productList[] = [
                'value' => $product->getName(),
                's'     => $product->getSku(), //sku
                'p'     => $this->_priceHelper->currencyByStore($finalPrice, $store, false, false), //price
                'i'     => $this->getMediaHelper()->getProductImage($product, 'mpsearch_image'),//image
                'u'     => $this->getProductUrl($product) //product url
            ];
        }

        $this->getMediaHelper()->createJsFile(
            $this->getJsFilePath($group, $store),
            'var mageplazaSearchProducts = ' . self::jsonEncode($productList)
        );

        return $this;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return bool|string
     */
    protected function getProductUrl($product)
    {
        $productUrl  = $product->getProductUrl();
        $requestPath = $product->getRequestPath();
        if (!$requestPath) {
            $pos = strpos($productUrl, 'catalog/product/view');
            if ($pos !== false) {
                $productUrl = substr($productUrl, $pos + 20);
            }
        } else {
            $productUrl = $requestPath;
        }

        return $productUrl;
    }

    /**
     * @param int $customerGroupId
     * @param \Magento\Store\Model\Store $store
     * @return string
     */
    public function getJsFilePath($customerGroupId, $store)
    {
        return Media::TEMPLATE_MEDIA_PATH . '/' . $store->getCode() . '_' . $customerGroupId . '.js';
    }

    /**
     * @return string
     */
    public function getJsFileUrl()
    {
        $customerGroupId = $this->_customerSession->getCustomerGroupId();

        /** @var \Magento\Store\Model\Store $store */
        $store = $this->storeManager->getStore();

        $mediaDirectory = $this->getMediaHelper()->getMediaDirectory();
        $filePath       = $this->getJsFilePath($customerGroupId, $store);
        if (!$mediaDirectory->isFile($filePath)) {
            $this->createJsonFileForStore($store, $customerGroupId);
        }

        return $this->getMediaHelper()->getMediaUrl($filePath);
    }

    /**
     * @return string
     */
    public function getPriceFormat()
    {
        return self::jsonEncode($this->localeFormat->getPriceFormat());
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getMaxResultAllowShow($storeId = null)
    {
        return $this->getModuleConfig('search/limit_search_results', $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getMinCharacterToQuery($storeId = null)
    {
        return $this->getModuleConfig('search/minimum_character', $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getAllowDisplayImageConfig($storeId = null)
    {
        return $this->getModuleConfig('search/display_product_image', $storeId);
    }
}