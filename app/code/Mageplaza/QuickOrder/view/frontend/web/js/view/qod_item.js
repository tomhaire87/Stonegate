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
define([
    'jquery',
    'ko',
    'uiComponent',
    'Mageplaza_QuickOrder/js/model/qod_item',
    'Magento_Catalog/js/price-utils',
    'Magento_Customer/js/customer-data',
    'mage/translate'
], function ($, ko, Component, itemModel, priceUtils, customerData, $t) {
    'use strict';
    var self;
    return Component.extend({
        defaults: {
            template: 'Mageplaza_QuickOrder/qod_item'
        },

        /**
         * init function
         */
        initialize: function () {
            this._super();
            self = this;
        },

        /**
         * get Items
         */
        getItems: function () {
            return itemModel.items();
        },

        /**
         * FormatPrice
         */
        getFormattedPrice: function (price) {
            return priceUtils.formatPrice(price, window.qodConfig.priceFormat);
        },

        /**
         * get Items
         */
        getItemsFromStorage: function () {
            // Retrieve the object from storage
            var retrievedObject = JSON.parse(localStorage.getItem('qodItems'));

            return retrievedObject;
        },

        /**
         * remove Item in list
         */
        removeItem: function (item_id) {
            itemModel.removeItem(item_id);
        },

        /**
         * plus qty Item in list
         */
        plusQty: function (item_id) {
            itemModel.plusQty(item_id);
        },

        /**
         * minus qty Item in list
         */
        minusQty: function (item_id) {
            itemModel.minusQty(item_id);
        },

        /**
         * change options of Item in list
         */
        changeOptions: function (item_id, optionId, event) {
            itemModel.changeOptions(item_id, optionId, event);
        },

        /**
         * change qty Item in list
         */
        changeQty: function (item_id, event) {
            itemModel.changeQty(item_id, event);
        },

        /**
         * double Item in list
         */
        doubleItem: function (item_id) {
            itemModel.doubleItem(item_id);
        },

        /**
         * check show type dom element for item
         */
        checktypeId: function (typeId) {
            var checktype = false;
            if (typeId == 'configurable') {
                checktype = true;
            }
            return checktype;
        },

        /**
         * check type show qty of stock dom element for item
         */
        checkTypeShowQty: function (typeId) {
            var checktype = false;
            if (typeId == 'configurable' || typeId == 'simple') {
                checktype = true;
            }
            return checktype;
        },

        /**
         * check product out of stock for item
         */
        checkoutofStock: function (outofstock) {
            return outofstock == false ? true : false;
        },

        /**
         * Add item to cart
         */
        addCartAction: function () {
            var sections = ['cart'];
            itemModel.addCartAction();
            customerData.invalidate(sections);
        },

        /**
         * Add item to cart and redirect to checkout process
         */
        checkoutProcessAction: function () {
            var sections = ['cart'];
            itemModel.checkoutProcessAction();
            customerData.invalidate(sections);
        }
    })
});
