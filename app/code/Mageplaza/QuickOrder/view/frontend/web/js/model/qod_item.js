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
define(
    [
        'jquery',
        'ko',
        'Mageplaza_QuickOrder/js/model/resource/item'
    ],
    function ($, ko, Item) {
        "use strict";
        var self = this;
        /**
         * Items object to manage quote items
         * @type {{items: *, initialize: Items.initialize, getItems: Items.getItems, getAddedItem: Items.getAddedItem, addItem: Items.addItem, getItem: Items.getItem, removeItem: Items.removeItem}}
         */
        var Items = {
            /**
             * List of cart items
             */
            items: ko.observableArray(),

            /**
             * Constructor
             * @returns {Items}
             */
            initialize: function () {
                self = this;
                /**
                 * Check if itemlist is empty
                 */
                self.isEmpty = ko.pureComputed(function () {
                    return (self.items().length > 0) ? false : true;
                });

                var retrievedObject = JSON.parse(localStorage.getItem('qodItems'));

                if (retrievedObject) {
                    this.items(retrievedObject);
                }

                return self;
            },

            /**
             * Get list of cart items
             * @returns {*}
             */
            getItems: function () {
                return this.items();
            },

            /**
             * Add product to list item
             * @param data
             */
            addItem: function (data) {
                var item = Item.init(data);
                this.items.push(item);
                this.setLocalStorage();
            },

            /**
             * Add product to list item
             * @param data
             */
            addItemFixPosition: function (i, data) {
                this.items.splice(i, 0, data);

                this.setLocalStorage();
            },

            /**
             * Get list of cart items
             * @returns {*}
             */
            doubleItem: function (itemId) {
                var olditem = false,
                    allItem = ko.observableArray([]);
                allItem(this.items.slice());
                var itemdouble = JSON.parse(JSON.stringify(allItem()));

                $.each(itemdouble, function (i, itemSelected) {
                    if (itemSelected.item_id == itemId) {
                        if (itemSelected.type_id != 'simple') {
                            var dataPrepare = $.extend({}, itemSelected);
                            dataPrepare.item_id = dataPrepare.item_id + 1;
                            self.addItem(dataPrepare);
                            return false;
                        }
                    }
                });

                this.setLocalStorage();
            },

            /**
             * Get cart item by item id
             * @param itemId
             * @returns {boolean}
             */
            getItem: function (itemId) {
                var item = false;
                var foundItem = ko.utils.arrayFirst(this.items(), function (item) {
                    return (item.item_id == itemId);
                });
                if (foundItem) {
                    item = foundItem;
                }
                return item;
            },


            /**
             * Get item existing by type and sku
             * @param itemId
             * @returns {boolean}
             */
            getItemExisted: function (typeId, sku) {
                var itemExisted = false;
                var foundItem = ko.utils.arrayFirst(this.items(), function (item) {
                    if (typeId != 'configurable') {
                        return (item.sku == sku);
                    }
                });
                if (foundItem) {
                    itemExisted = true;
                }
                return itemExisted;
            },

            /**
             * Remove item by id
             * @param itemId
             */
            removeItem: function (itemId) {
                this.items.remove(function (item) {
                    return item.item_id == itemId;
                });

                this.setLocalStorage();
            },

            /**
             * get sku item by id
             * @param itemId
             */
            getskuItem: function (list_items, itemId) {
                var skuItem = null;

                /** get sku Item data*/
                $.each(list_items, function (i, itemUpdate) {
                    if (itemUpdate.item_id == itemId) {
                        if (itemUpdate.sku_child) {
                            skuItem = itemUpdate.sku_child;
                        } else {
                            skuItem = itemUpdate.sku;
                        }
                    }
                });

                return skuItem;
            },

            /**
             * plus qty item by id
             * @param itemId
             */
            plusQty: function (itemId) {
                var olditem = false,
                    allItem = ko.observableArray([]),
                    skuItem = null,
                    stockQtyofItem = null,
                    urlStockQty = window.qodConfig.itemqty,
                    el_lazyload = $('#lazyload');
                allItem(this.items.slice());

                skuItem = self.getskuItem(allItem(), itemId);
                el_lazyload.show();
                $.ajax({
                    url: urlStockQty,
                    data: {
                        itemsku: skuItem
                    },
                    method: 'POST',
                    success: function (response) {
                        stockQtyofItem = response;
                        /** remove old item to change qty and replace new data*/
                        $.each(allItem(), function (i, itemUpdate) {
                            if (itemUpdate.item_id == itemId) {
                                if (itemUpdate.type_id == 'configurable' || itemUpdate.type_id == 'simple') {
                                    if (itemUpdate.qty < stockQtyofItem) {
                                        self.removeItem(itemId);
                                        itemUpdate.qtystock = stockQtyofItem;
                                        itemUpdate.qty = parseInt(itemUpdate.qty) + 1;
                                        itemUpdate.total = parseInt(itemUpdate.qty) * itemUpdate.price;
                                        self.addItemFixPosition(i, itemUpdate);
                                    }
                                    el_lazyload.hide();
                                } else {
                                    self.removeItem(itemId);
                                    itemUpdate.qtystock = stockQtyofItem;
                                    itemUpdate.qty = parseInt(itemUpdate.qty) + 1;
                                    itemUpdate.total = parseInt(itemUpdate.qty) * itemUpdate.price;
                                    self.addItemFixPosition(i, itemUpdate);
                                    el_lazyload.hide();
                                }
                            }
                        });
                    }
                });

                this.items(allItem());
                this.setLocalStorage();
            },

            /**
             * minus qty item by id
             * @param itemId
             */
            minusQty: function (itemId) {
                var olditem = false,
                    allItem = ko.observableArray([]);
                allItem(this.items.slice());

                $.each(allItem(), function (i, itemUpdate) {
                    if (itemUpdate.item_id == itemId) {
                        if (parseInt(itemUpdate.qty) > 1) {
                            self.removeItem(itemId);
                            itemUpdate.qty = parseInt(itemUpdate.qty) - 1;
                            itemUpdate.total = itemUpdate.total - itemUpdate.price;
                            self.addItemFixPosition(i, itemUpdate);
                        }
                    }
                    ;
                });

                this.items(allItem());
                this.setLocalStorage();
            },

            /**
             * save item
             */
            getAllItems: function () {
                var items = this.items();
                return items;
            },


            /**
             * change Qty
             */
            changeQty: function (itemId, event) {
                var allItem = ko.observableArray([]),
                    valueInput = event.currentTarget.value,
                    skuItem = null,
                    stockQtyofItem = null,
                    urlStockQty = window.qodConfig.itemqty,
                    el_lazyload = $('#lazyload');
                allItem(this.items.slice());

                skuItem = self.getskuItem(allItem(), itemId);
                el_lazyload.show();
                $.ajax({
                    url: urlStockQty,
                    data: {
                        itemsku: skuItem
                    },
                    method: 'POST',
                    success: function (response) {
                        stockQtyofItem = response;
                        /** remove old item to change qty and replace new data*/
                        $.each(allItem(), function (i, itemUpdate) {
                            if (itemUpdate.item_id == itemId) {
                                if (parseInt(valueInput) <= parseInt(stockQtyofItem)) {
                                    self.removeItem(itemId);
                                    itemUpdate.qty = parseInt(valueInput);
                                    itemUpdate.total = parseInt(itemUpdate.qty) * itemUpdate.price;
                                    self.addItemFixPosition(i, itemUpdate);
                                } else {
                                    self.removeItem(itemId);
                                    self.addItemFixPosition(i, itemUpdate);
                                }
                                el_lazyload.hide();
                            }
                        });
                    }
                });

                this.items(allItem());
                this.setLocalStorage();
            },

            /**
             * change Options of each item
             * @param itemId
             */
            changeOptions: function (itemId, optionId, event) {
                var allItem = ko.observableArray([]),
                    attributeSelect = optionId,
                    attrValueSelected = event.currentTarget.selectedOptions[0].value;
                allItem(this.items.slice());

                /** update key options*/
                $.each(allItem(), function (i, itemUpdate) {
                    if (itemUpdate.item_id == itemId) {
                        /** set attribute and value changed*/
                        $.each(itemUpdate.options, function (i, opAttribute) {
                            var opSplit = opAttribute.split(':'),
                                attributeChange = opSplit[0],
                                valueSelected = opSplit[1];

                            if (attributeChange == attributeSelect) {
                                valueSelected = attrValueSelected;
                                /** set order array value select*/
                                var options_select_value = itemUpdate.options_select_value[attributeChange];
                                $.each(options_select_value, function (key, value) {
                                    if (valueSelected == value) {
                                        options_select_value.splice(key, 1);
                                        options_select_value.unshift(valueSelected);
                                    }
                                });
                            }
                            opAttribute = attributeChange + ':' + valueSelected;
                            itemUpdate.options[i] = opAttribute;
                        });
                    }
                    ;
                });

                /** update key optionIds*/
                $.each(allItem(), function (i, itemUpdate) {
                    if (itemUpdate.item_id == itemId) {
                        /** find attribute Id need change*/
                        var superAttribute = itemUpdate.super_attribute,
                            attrNeedChange = '';
                        $.each(superAttribute, function (i, supperCode) {
                            var codeIdSplit = supperCode.split(':'),
                                attrCodeId = codeIdSplit[0],
                                attrCode = codeIdSplit[1];

                            if (attributeSelect == attrCode) {
                                attrNeedChange = attrCodeId;
                            }
                        });

                        /** set attribute and value changed*/
                        $.each(itemUpdate.optionIds, function (i, opIdAttribute) {
                            var opIdSplit = opIdAttribute.split(':'),
                                attributeChange = opIdSplit[0],
                                valueIdSelected = opIdSplit[1],
                                valuechange = valueIdSelected;


                            if (attributeChange == attrNeedChange) {
                                valueIdSelected = attrValueSelected;
                                /** update Id*/
                                var options_select_value_id = itemUpdate.options_select_value_id[attributeSelect];
                                $.each(options_select_value_id, function (key, value) {
                                    var idvalue = value.split(':');
                                    if (valueIdSelected == idvalue[1]) {
                                        valuechange = idvalue[0];
                                    }
                                });
                            }
                            opIdAttribute = attributeChange + ':' + valuechange;
                            itemUpdate.optionIds[i] = opIdAttribute;
                        });
                    }
                    ;
                });

                this.items(allItem());
                this.setLocalStorage();
            },

            /**
             * set Local Storage
             */
            setLocalStorage: function () {
                return localStorage.setItem('qodItems', JSON.stringify(this.items()));
            },

            /**
             * set Local Storage
             */
            clearLocalStorage: function () {
                return localStorage.removeItem('qodItems');
            },

            /**
             * get Data From search
             */
            getDataItemsFromSearch: function (sku) {
                var texts = [sku + ',' + 1],
                    url = window.qodConfig.buildItemUrl,
                    el_search = $('#quickod-instansearch');

                $.ajax({
                    url: url,
                    data: {
                        value: texts
                    },
                    method: 'POST',
                    success: function (response) {
                        if (response != '') {
                            for (var key in response) {
                                if (!response.hasOwnProperty(key)) continue;
                                var obj = response[key];
                                self.addItem(obj);
                                el_search.val('');
                            }
                        }
                    }
                });
            },

            /**
             * Add item to cart
             */
            addCartAction: function () {
                var items = this.items(),
                    url = window.qodConfig.addCartAction,
                    url_cart_page = window.qodConfig.cartpage,
                    el_error_message = $('#addcart-message'),
                    el_lazyload = $('#lazyload');

                if (items.length == 0 || items == '') {
                    self.showMessage(el_error_message, 5000);
                } else {
                    el_error_message.hide();
                    el_lazyload.show();
                    $.ajax({
                        url: url,
                        data: {
                            listitem: items
                        },
                        method: 'POST',
                        success: function (response) {
                            if (response) {
                                self.clearAllItems();
                                el_lazyload.hide();
                                self.redirectNextProcess(url_cart_page);
                            }
                        }
                    });
                }
            },

            /**
             * Add item to cart and redirect to checkout process
             */
            checkoutProcessAction: function () {
                var items = this.getItems(),
                    url = window.qodConfig.addCartAction,
                    url_checkout_step = window.qodConfig.checkoutStep,
                    el_error_message = $('#addcart-message'),
                    el_lazyload = $('#lazyload');

                if (items.length == 0 || items == '') {
                    self.showMessage(el_error_message, 5000);
                } else {
                    el_error_message.hide();
                    el_lazyload.show();
                    $.ajax({
                        url: url,
                        data: {
                            listitem: items
                        },
                        method: 'POST',
                        success: function (response) {
                            if (response) {
                                self.clearAllItems();
                                el_lazyload.hide();
                                self.redirectNextProcess(url_checkout_step);
                            }
                        }
                    });
                }
            },

            /**
             * show message
             */
            showMessage: function (el, timedelay) {
                el.show();
                if (timedelay <= 0) timedelay = 5000;
                setTimeout(function () {
                    el.hide();
                }, timedelay);
            },

            /**
             * redirect to cart page
             */
            redirectNextProcess: function (url_next_process) {
                $(location).attr("href", url_next_process);
            },

            /**
             * remove all item
             */
            clearAllItems: function () {
                self.items.removeAll();
                this.clearLocalStorage();
            }
        }
        return Items.initialize();
    }
);