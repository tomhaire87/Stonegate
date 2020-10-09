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
 * @package     Mageplaza_GiftCard
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\GiftCard\Block\Checkout\Item;

use Magento\Framework\App\ObjectManager;
use Mageplaza\GiftCard\Helper\Product;

/**
 * Class Renderer
 * @package Mageplaza\GiftCard\Block\Checkout\Item
 */
class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    /**
     * Return gift card and custom options array
     *
     * @return array
     */
    public function getOptionList()
    {
        /** @var Product $helper */
        $helper = ObjectManager::getInstance()->get(Product::class);
        $item = $this->getItem();
        $customOptions = $this->_productConfig->getCustomOptions($item);

        return $helper->getOptionList($item, $customOptions);
    }
}
