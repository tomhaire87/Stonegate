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

namespace Mageplaza\GiftCard\Plugin\Block;

use Magento\Checkout\Block\Cart\Coupon;
use Magento\Framework\Exception\LocalizedException;
use Mageplaza\GiftCard\Helper\Checkout as CheckoutHelper;

/**
 * Class CartCoupon
 * @package Mageplaza\GiftCard\Plugin
 */
class CartCoupon
{
    /**
     * @type CheckoutHelper
     */
    protected $helper;

    /**
     * CartCoupon contructor.
     *
     * @param CheckoutHelper $checkoutHelper
     */
    public function __construct(CheckoutHelper $checkoutHelper)
    {
        $this->helper = $checkoutHelper;
    }

    /**
     * @param Coupon $subject
     * @param                                     $coupon
     *
     * @return mixed
     */
    public function afterGetCouponCode(Coupon $subject, $coupon)
    {
        if (!$this->helper->isEnabled() || !$this->helper->isUsedCouponBox()) {
            return $coupon;
        }

        $giftCards = $this->helper->getGiftCardsUsed();
        if (sizeof($giftCards)) {
            return array_keys($giftCards)[0];
        }

        return $coupon;
    }

    /**
     * @param Coupon $subject
     * @param string $html
     *
     * @return string
     * @throws LocalizedException
     */
    public function afterToHtml(Coupon $subject, $html)
    {
        $giftCardHtml = $subject->getLayout()
            ->createBlock(
                'Magento\Framework\View\Element\Template',
                'mageplaza.gift.card.checkout.cart.coupon'
            )
            ->setTemplate('Mageplaza_GiftCard::cart/coupon.phtml');

        return $giftCardHtml->toHtml() . $html;
    }
}
