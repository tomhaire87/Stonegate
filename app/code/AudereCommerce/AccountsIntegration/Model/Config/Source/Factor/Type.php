<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Factor;

use Magento\Framework\Option\ArrayInterface;

class Type implements ArrayInterface
{

    const OPTION_DIVIDE_PRICE_DIVIDE_QUANTITY = 1;
    const OPTION_MULTIPLY_PRICE_MULTIPLY_QUANTITY = 2;

    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::OPTION_DIVIDE_PRICE_DIVIDE_QUANTITY,
                'label' => 'Price and stock levels are based on boxes/multiple units in accounts software, single units as single Magento products. Price and stock are divided on import, and quantity is divided on order export (representing a % of a full box).' // Divide price, multiply quantity
            ),
            array(
                'value' => self::OPTION_MULTIPLY_PRICE_MULTIPLY_QUANTITY,
                'label' => 'Price and stock levels are based on single units in accounts software, with boxes/multiple units as single Magento products. Price and stock are multiplied on import, and quantity is multiplied on order export.' // Multiple price, divide quantity
            )
        );
    }

}
