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

namespace Mageplaza\QuickOrder\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class CustomerGroup
 * @package Mageplaza\QuickOrder\Model\Config\Source
 */
class CustomerGroup implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $groupOptions  = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();

        return $groupOptions;
    }
}
