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

namespace Mageplaza\GiftCard\Block\Adminhtml\Grid\Column\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\Price as SourcePrice;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Price
 * @package Mageplaza\GiftCard\Block\Adminhtml\Grid\Column\Renderer
 */
class Price extends SourcePrice
{
    /**
     * Returns currency code for the row, false on error
     *
     * @param DataObject $row
     *
     * @return string|false
     */
    protected function _getCurrencyCode($row)
    {
        $storeId = $row->getData('store_id');
        $store = ObjectManager::getInstance()->get(StoreManagerInterface::class)
            ->getStore($storeId);

        return $store->getBaseCurrencyCode();
    }
}
