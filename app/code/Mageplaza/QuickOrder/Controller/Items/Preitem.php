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

namespace Mageplaza\QuickOrder\Controller\Items;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\QuickOrder\Helper\Data;
use Mageplaza\QuickOrder\Helper\Item as QodItemHelper;

/**
 * Class Preitem
 * @package Mageplaza\QuickOrder\Controller\Items
 */
class Preitem extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Mageplaza\QuickOrder\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Mageplaza\QuickOrder\Helper\Item
     */
    protected $_itemhelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storemanager;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     * Preitem constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Mageplaza\QuickOrder\Helper\Data $helperData
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Mageplaza\QuickOrder\Helper\Item $itemhelper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Data $helperData,
        StoreManagerInterface $storeManager,
        JsonHelper $jsonHelper,
        QodItemHelper $itemhelper
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_helperData       = $helperData;
        $this->_storemanager     = $storeManager;
        $this->_jsonHelper       = $jsonHelper;
        $this->_itemhelper       = $itemhelper;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $store = $this->_helperData->getStore();
        $group = $this->_helperData->getCustomerGroupId();
        $data  = $this->getRequest()->getParam('value');

        if (!$data) {
            return $this->getResponse()->setBody(false);
        }
        $preItem = array();
        if ($data) {
            foreach ($data as $key => $value) {
                $value_array              = explode(',', $value);
                $getProductInfoCollection = $this->_itemhelper->getProductCollectionForStore($value_array[0], $store, $group);
                /** isset sku and qty input*/
                if (isset($value_array[1]) && (intval($value_array[1]) > 0)) {
                    /** Check request item not meet all conditions filter of getProductCollectionForStore but maybe out of stock*/
                    if (!sizeOf($getProductInfoCollection)) {
                        $preItem[] = $this->_itemhelper->getPreItemNotMeetConditionsFilter($value_array[0], $value_array[1]);
                    } else {
                        /** Check request item meet all conditions filter*/
                        foreach ($getProductInfoCollection as $info) {
                            $productName   = $info->getName();
                            $getFinalPrice = $info->getFinalPrice();
                            $productId     = $info->getId();
                            $productSKU    = $info->getSku();
                            $typeId        = $info->getTypeId();
                        }

                        if ($typeId != 'bundle' && $typeId != 'grouped') {
                            if ($typeId == 'configurable') {
                                /** validate options item input before add preItem array*/
                                $options         = array();
                                $optionIds       = array();
                                $valueCheck      = $value_array;
                                $count           = 0;
                                $attributeOption = $this->_itemhelper->getProductAttributeOptions($productId);
                                $no_option       = sizeof($attributeOption);
                                $sizeOf          = sizeof($valueCheck);
                                /** case customer only input configuration product only sku,qty size <= 2*/
                                if ($sizeOf < 3) {
                                    /**validate value and attribute code of product*/
                                    $getProductOptionDefault  = $this->_itemhelper->getProductOptionDefaultValue($attributeOption);
                                    $getOptionIdsDefaultValue = $this->_itemhelper->getOptionIdsDefaultValue($attributeOption);
                                    $getSelectValueDefault    = $this->_itemhelper->getSelectValueDefault($attributeOption, $attrcodeInput = '', $valueOfAttrCodeInput = '');
                                    $getSelectValueIdKey      = $this->_itemhelper->getSelectValueIdKey($attributeOption);
                                    $productAttributeId       = $this->_itemhelper->getOptionIdsDefaultParam($attributeOption);
                                    $product_children_simple  = $this->_itemhelper->getchidrenSimpleProudctByAttribute($productAttributeId, $productId);
                                    $superAttribute           = $this->_itemhelper->getSuperAttribute($attributeOption);
                                    $skuChild                 = '';
                                    $preItem[]                = $this->_itemhelper->getPreItemDataArray($productId, $productName, $productSKU, $product_children_simple->getSku(), $value_array[1], $product_children_simple->getFinalPrice(), $store, $typeId, $getProductOptionDefault, $getOptionIdsDefaultValue, $getSelectValueDefault, $getSelectValueIdKey, $superAttribute);
                                } else {
                                    /** case customer input configuration product have option sizeof >= 3*/
                                    $statusCheckAlloptions = true;
                                    $countOption           = 0;
                                    $selectValueConvert    = array();
                                    $productAttributeId    = array();
                                    foreach ($valueCheck as $option) {
                                        $count++;
                                        if ($count >= 3) {
                                            /**validate value and attribute code of product*/
                                            $countOption++;
                                            $option_input = explode(':', $option);
                                            if (isset($option_input[0]) && isset($option_input[1])) {
                                                $attrcode        = $option_input[0];
                                                $valueOfAttrCode = $option_input[1];
                                            } else {
                                                $attrcode        = '';
                                                $valueOfAttrCode = '';
                                            }
                                            $getValidateCode         = $this->_itemhelper->checkAttributeCode($attrcode, $attributeOption);
                                            $validateValueofAttrCode = $this->_itemhelper->checkValueOfAttributeCode($valueOfAttrCode, $attributeOption);

                                            $getcheckAttributeCodeId        = $this->_itemhelper->getcheckAttributeCodeId($attrcode, $attributeOption);
                                            $getcheckIdValueOfAttributeCode = $this->_itemhelper->getcheckIdValueOfAttributeCode($valueOfAttrCode, $attributeOption);
                                            $getSelectValueDefault          = $this->_itemhelper->getSelectValueDefault($attributeOption, $attrcode, $valueOfAttrCode);
                                            $selectValueConvert             = $this->_itemhelper->getSelectValueConvertOption($attrcode, $valueOfAttrCode, $selectValueConvert, $getSelectValueDefault);
                                            $getSelectValueIdKey            = $this->_itemhelper->getSelectValueIdKey($attributeOption);
                                            $superAttribute                 = $this->_itemhelper->getSuperAttribute($attributeOption);
                                            $options[]                      = $option;
                                            $optionIds[]                    = $getcheckAttributeCodeId . ':' . $getcheckIdValueOfAttributeCode;
                                            $productAttributeId             += [$getcheckAttributeCodeId => $getcheckIdValueOfAttributeCode];
                                            if (!$getValidateCode || !$validateValueofAttrCode) {
                                                $statusCheckAlloptions = false;
                                            }
                                        }
                                    }

                                    /** convert option follow order option of product*/
                                    $orderAttribute   = array();
                                    $optionIdsConvert = array();
                                    foreach ($superAttribute as $superA) {
                                        $itemArray        = explode(':', $superA);
                                        $orderAttribute[] = $itemArray[0];
                                    }

                                    foreach ($orderAttribute as $orderA) {
                                        foreach ($optionIds as $optionIdA) {
                                            $itemArray = explode(':', $optionIdA);
                                            if ($itemArray[0] == $orderA) {
                                                $optionIdsConvert[] = $optionIdA;
                                            }
                                        }
                                    }
                                    /** end convert option follow order option of product*/

                                    $product_children_simple = $this->_itemhelper->getchidrenSimpleProudctByAttribute($productAttributeId, $productId);

                                    if ($statusCheckAlloptions && $countOption == $no_option) {
                                        $preItem[] = $this->_itemhelper->getPreItemDataArray($productId, $productName, $productSKU, $product_children_simple->getSku(), $value_array[1], $product_children_simple->getFinalPrice(), $store, $typeId, $options, $optionIdsConvert, $selectValueConvert, $getSelectValueIdKey, $superAttribute);
                                    }
                                }
                            } else {
                                /** other product type*/
                                $preItem[] = $this->_itemhelper->getPreItemDataArray($productId, $productName, $productSKU, $skuChild = '', $value_array[1], $getFinalPrice, $store, $typeId, $options = '', $optionIds = '', $optionSelectValue = '', $getSelectValueIdKey = '', $superAttribute = '');
                            }
                        }
                    }
                }
            }

            return $this->getResponse()->representJson(
                $this->_jsonHelper->jsonEncode($preItem)
            );
        }

        return;
    }
}