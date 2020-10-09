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
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Mageplaza\QuickOrder\Helper\Item as QodItemHelper;

/**
 * Class Itemqty
 * @package Mageplaza\QuickOrder\Controller\Items
 */
class Itemqty extends Action
{
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var \Mageplaza\QuickOrder\Helper\Item
     */
    protected $_itemHelper;

    /**
     * Itemqty constructor.
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param QodItemHelper $itemHelper
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        QodItemHelper $itemHelper
    )
    {
        $this->_productRepository = $productRepository;
        $this->_itemHelper        = $itemHelper;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $itemSku = $this->getRequest()->getParam('itemsku');
        if (!$itemSku) {
            return $this->getResponse()->setBody(false);
        }
        $productItem = $this->_productRepository->get($itemSku);
        $productId   = $productItem->getId();
        $itemQty     = $this->_itemHelper->getProductQtyStock($skuChild = '', $productId);

        return $this->getResponse()->setBody($itemQty);
    }
}