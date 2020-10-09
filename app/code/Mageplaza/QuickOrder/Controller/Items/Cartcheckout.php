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

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey;
use Mageplaza\QuickOrder\Helper\Item as QodItemHelper;
use Psr\Log\LoggerInterface;

/**
 * Class Cartcheckout
 * @package Mageplaza\QuickOrder\Controller\Items
 */
class Cartcheckout extends Action
{
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $_cart;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $_formKey;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Mageplaza\QuickOrder\Helper\Item
     */
    protected $_itemHelper;

    /**
     * Cartcheckout constructor.
     * @param Context $context
     * @param Cart $cart
     * @param ProductRepositoryInterface $productRepository
     * @param FormKey $formKey
     * @param LoggerInterface $logger
     * @param QodItemHelper $itemHelper
     */
    public function __construct(
        Context $context,
        Cart $cart,
        ProductRepositoryInterface $productRepository,
        FormKey $formKey,
        LoggerInterface $logger,
        QodItemHelper $itemHelper
    )
    {
        $this->_cart              = $cart;
        $this->_productRepository = $productRepository;
        $this->_formKey           = $formKey;
        $this->_logger            = $logger;
        $this->_itemHelper        = $itemHelper;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('listitem');
        if (!$data) {
            return $this->getResponse()->setBody(false);
        }

        foreach ($data as $item) {
            $product        = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)->load($item['product_id']);
            $productInstock = $this->_itemHelper->getProductOutofStock($product->getId());
            if (!$productInstock) {
                continue;
            }

            $qty         = $item['qty'];
            $productType = $product->getTypeId();
            if ($productType == 'configurable') {
                $idsAttrAddcart = [];
                foreach ($item['optionIds'] as $optionchoose) {
                    $attribute = explode(':', $optionchoose);
                    foreach ($attribute as $attr) {
                        $idsAttrAddcart[] = $attr;
                    }
                }
                /** prepare data fore super_attribute to add option to cart*/
                $optionAddcart = [];
                for ($i = 0; $i <= sizeof($idsAttrAddcart); $i++) {
                    $iIn = $i++;
                    if (isset($idsAttrAddcart[$i])) {
                        $optionAddcart += [intval($idsAttrAddcart[$iIn]) => $idsAttrAddcart[$i]];
                    }
                }

                $params = [
                    'product'         => $product->getId(),
                    'qty'             => $qty,
                    'super_attribute' => $optionAddcart
                ];

                try {
                    $this->_cart->addProduct($product, $params);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__("Something went wrong when adding " . $product->getName() . " to cart. Please check it again."));

                    return $this->getResponse()->setBody(false);
                }
            } else if (!in_array($productType, ['bundle', 'grouped'])) {
                /** other type product like simple, vitual, downloadable ...*/
                $params = [
                    'product' => $product->getId(),
                    'qty'     => $qty
                ];

                try {
                    $this->_cart->addProduct($product, $params);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__("Something went wrong when adding " . $product->getName() . " to cart. Please check it again."));

                    return $this->getResponse()->setBody(false);
                }
            }
        }

        try {
            $this->_cart->save();
            $this->messageManager->addSuccessMessage(__('Added products to cart successfully!'));

            return $this->getResponse()->setBody(true);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong when adding product to cart. Please check it again.'));

            return $this->getResponse()->setBody(false);
        }
    }
}