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

namespace Mageplaza\GiftCard\Plugin\Controller\Product;

use Magento\Framework\App\RequestInterface;
use Mageplaza\GiftCard\Ui\DataProvider\Product\Modifier\GiftCard;

/**
 * Class Builder
 * @package Mageplaza\GiftCard\Plugin\Controller\Product
 */
class Builder
{
    /**
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $subject
     * @param RequestInterface $request
     */
    public function beforeBuild(
        \Magento\Catalog\Controller\Adminhtml\Product\Builder $subject,
        RequestInterface $request
    ) {
        $params = $request->getPost('product');

        if ($request->getParam('type') == 'mpgiftcard' && !isset($params[GiftCard::FIELD_GIFT_CARD_AMOUNTS])) {
            $params[GiftCard::FIELD_GIFT_CARD_AMOUNTS] = [];
            $request->setPostValue('product', $params);
        }
    }
}
