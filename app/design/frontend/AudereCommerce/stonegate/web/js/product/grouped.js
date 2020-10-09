!(function ($) {
    var getCurrency = function () {
        return $('.table-wrapper.grouped').data('currency');
    };
    $('.table.grouped input.qty').each(function () {
        var input = $(this);
        var priceBox = input.parents('tr').find('.price-final_price_total .price');
        var singlePrice = input.data('price');
        var tierPrices = input.data('tier-price');
        if (tierPrices !== undefined) {
            var getPrice = function (qty) {
                qty = Number(qty);
                var i = Object.keys(tierPrices).length;
                while (i--) {
                    var itemId = Object.keys(tierPrices)[i];
                    if (qty >= tierPrices[itemId]['price_qty']) {
                        return (tierPrices[itemId]['price'] * parseInt(input.val())).toFixed(2);
                    }
                }
                while (i++) {
                    var itemId = Object.keys(tierPrices)[i];
                    if (qty <= tierPrices[itemId]['price_qty']) {
                        return (singlePrice * parseInt(input.val())).toFixed(2);
                    }
                }
                return null;
            }
            var updatePrice = function (price) {
                priceBox.html(getCurrency() + price);
            }
            input.change(function () {
                var price = getPrice(this.value);
                if (price !== null) {
                    updatePrice(price);
                }
                priceBox.parents('td.col.price').addClass('visible');
            });
        } else {
            input.change(function () {
                priceBox.html(getCurrency() + (singlePrice * input.val()).toFixed(2));
                priceBox.parents('td.col.price').addClass('visible');
                if (input.val() == 0) {
                    console.log('Value is 0');
                    priceBox.parents('td.col.price').removeClass('visible');
                }
            });
        }
    });
    $('.table.grouped input.qty').change(function () {
        var total = 0;
        $('.price-container.price-final_price_total .price').each(function () {
            total += parseFloat($(this).text().replace(/[^0-9\.]+/g, ""));
        });
        $('.totals .subtotal').text(getCurrency() + total.toFixed(2));
    });

    $('td.compare input').change(function () {
        if ($('td.compare input:checked').length) {
            $('.grouped.action.tocompare').prop('disabled', false);
        } else {
            $('.grouped.action.tocompare').prop('disabled', true);
        }
    });

    $('.grouped.action.tocompare').click(function (e) {
        e.preventDefault();

        var button = $(this);

        if (!button.hasClass('disabled')) {
            button.addClass('disabled');

            var ids = $('td.compare input:checked').map(function () {
                return $(this).data('id');
            }).get().join();

            $.ajax({
                type: 'POST',
                url: $(this).attr('href'),
                data: {products: ids},
                success: function () {
                    button.removeClass('disabled');
                }
            })
        }

        // v1

        // var url = $(this).attr('href');
        //
        // var ids = $('td.compare input:checked').map(function () {
        //     return $(this).data('id');
        // }).get().join();
        //
        // window.location = url + 'products/' + ids;


        //v2

        // var form = document.createElement('form');
        //
        // form.setAttribute('method', 'post');
        // form.setAttribute('action', $(this).attr('href'));
        //
        // $('td.compare input:checked').each(function (key) {
        //     var input = $(this);
        //     var field = document.createElement('input');
        //
        //     field.setAttribute('type', 'hidden');
        //     field.setAttribute('name', 'products[' + key + ']');
        //     field.setAttribute('value', input.data('id'));
        //
        //     form.appendChild(field);
        // });
        //
        // document.body.appendChild(form);
        // form.submit();
    });

    $('body').on('click', '.table.grouped .qty-input > div', function () {
        var control = $(this);
        var input = control.siblings('input');
        input.focus();
        var value = parseInt(input.val());

        if (control.hasClass('subtract')) {
            input.val(value - 1).change();
        }

        if (control.hasClass('add')) {
            input.val(value + 1).change();
        }

        if (input.val() < 0) {
            input.val(0).change();
        }

        input.change();
    });

    $('tr.item-details td.qty').click(function () {
        $('tr.row-tier-price').removeClass('active');
        $(this).parent('tr.item-details').siblings('tr.row-tier-price').addClass('active');
    });

    $(document).ready(function () {
        $('.tier-price-outer').attr('colspan', $('.table.grouped th.col').length);
    });
})(jQuery);