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
define(['jquery'], function ($) {
        "use strict";
        return {
            initialize: function () {
                this._super();
                /**
                 * Object fields key.
                 * @type {string[]}
                 */
                this.initFields = [
                    'item_id',
                    'product_id',
                    'name',
                    'sku',
                    'sku_child',
                    'qty',
                    'qtystock',
                    'price',
                    'imageUrl',
                    'type_id',
                    'porudct_url',
                    'options',
                    'optionIds',
                    'options_select_value',
                    'options_select_value_id',
                    'super_attribute',
                    'outofstock'
                ];
            },
            /**
             * Init data
             * @param data
             */
            init: function (data) {
                var dataPrepare = $.extend({}, data);

                dataPrepare.item_id = parseInt(data.item_id) + parseInt($.now());
                dataPrepare.total = data.qty * data.price;

                return dataPrepare;
            }
        };
    }
);