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

namespace Mageplaza\GiftCard\Block\Adminhtml\Customer\Edit\Tab\Transaction;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;
use Mageplaza\GiftCard\Helper\Data;
use Mageplaza\GiftCard\Model\Transaction\Action;

/**
 * Class DetailRenderer
 * @package Mageplaza\GiftCard\Block\Adminhtml\Customer\Edit\Tab\Transaction
 */
class DetailRenderer extends AbstractRenderer
{
    /**
     * @param DataObject $row
     *
     * @return string
     */
    public function render(DataObject $row)
    {
        $params = is_array($row->getExtraContent()) ? $row->getExtraContent() : Data::jsonDecode($row->getExtraContent());

        return Action::getActionLabel($row->getAction(), $params);
    }
}
