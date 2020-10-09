<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Model\Config\Source\Shipment;

use Magento\Framework\Option\ArrayInterface;

class Quantity implements ArrayInterface
{

    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'delivered_quantity',
                'label' => 'Delivered Quantity'
            ),
            array(
                'value' => 'ordered_quantity',
                'label' => 'Ordered Quantity'
            )
        );
    }

}
