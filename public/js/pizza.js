$(document).ready(function(event) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(window).scroll(function (event) {
        var sct = $(this).scrollTop();

        if ($(window).scrollTop() > 100) {
            $('#top').css('position', 'fixed');
            $('#top').css('top', 0);
            $('#top').css('z-index', '10000');
            $('#top').css('width', '100%');
            $('#top').css('background', 'black');
        } else {
            $('#top').css('position', 'relative');
            $('#top').css('top', 0);
            $('#top').css('z-index', '10000');
        }
    });

    $('[data-id="product-order"]').click(function(event) {
        console.log('product-order');
        product_order(this);
    });

    $('[data-id="product-minus"]').click(function(event) {
        console.log('product-minus');
        product_minus(this);
    });

    $('[data-id="product-plus"]').click(function(event) {
        console.log('product-plus');
        product_plus(this);
    });

    $('[data-id="product-remove"]').click(function(event) {
        console.log('product-remove');
        product_remove(this);
    });
    
    $('[data-id="pizza-minus"]').click(function(event) {
        console.log('pizza-minus');
        pizza_minus(this)
    });
    
    $('[data-id="pizza-plus"]').click(function(event) {
        console.log('pizza-plus');
        pizza_plus(this);
    });
    
    $('[data-id="pizza-remove"]').click(function(event) {
        console.log('pizza-remove');
        pizza_remove(this);
    });

    // MODAL THANKS

    $('[data-id="modal-thanks"]').hide();

    $('[data-id="modal-thanks"] .thanks .close').click(function(event) {
        console.log('modal-thanks-close');
        modal_thanks_close(this);
    });

    $('.modal').click(function(event) {
        console.log('modal-close');
        modal_thanks_close($(this).find('.close'));
    });

    // DATETIME EXT
    $('[data-id="datetime"] input').inputmask({
        alias: 'h:s'
    });

    // FILTER
    $('[data-filter]').change(function(event) {
        category_filter(this, event);
    });

    $('#select').change(function(event) {
        category_filter(this, event);
    });

    $('.minus').click(function(event) {
        var count = $(this).next().find('span');
        var count_value = parseInt(count.html());
        if(count_value == 1) {
            // ingredients
            var ingredients = $('.top .ingredients');
            var ingredients_values = $('.top .ingredients .value');

            var ingredient_value = $(this).parent().parent().find('.name').find('span').first().html();

            if(ingredients_values.length != 0) {
                var has = false;
                for (var i = 0; i < ingredients_values.length; i++) {
                    if (ingredients_values[i].innerHTML == ingredient_value) {
                        $(ingredients_values[i]).remove();
                    }
                }
            }
        }

        if(count_value > 0) {
            count_value--;
            count.html(count_value);

            // weight

            var weight = $('.top .weight');
            var weight = weight.find('.value');

            var ingredient_weight = $(this).parent().parent().find('.name .weight');
            weight.html(parseInt(weight.html()) - parseInt(ingredient_weight.html()));

            // price
            var price_left = $('.top .price .left');
            var price_right = $('.top .price .right');
            var price_value = parseFloat(price_left.html() + '.' + price_right.html());

            var price_left_ingredient = $(this).parent().parent().find('.price .left');
            var price_right_ingredient = $(this).parent().parent().find('.price .right');
            var price_value_ingredient = parseFloat(price_left_ingredient.html() + '.' + price_right_ingredient.html());

            price_value *= 1000000;
            price_value_ingredient *= 1000000;
            var new_price = price_value - price_value_ingredient;
            new_price /= 1000000;
            var new_price = new_price.toString().split(/\./);
            if(new_price.length == 1) {
                new_price.push('00');
            }
            if(new_price[1].length == 1)
                new_price[1] += '0';
            new_price[1] = new_price[1].substr(0, 2);

            price_left.html(new_price[0]);
            price_right.html(new_price[1]);
        }
    });

    $('.plus').click(function(event) {
        var count = $(this).prev().find('span');
        var count_value = parseInt(count.html());
        if(count_value >= 3)
            return;
        count_value++;
        count.html(count_value);

        // weight

        var weight = $('.top .weight');
        var weight = weight.find('.value');

        var ingredient_weight = $(this).parent().parent().find('.name .weight');
        weight.html(parseInt(weight.html()) + parseInt(ingredient_weight.html()));

        // price
        var price_left = $('.top .price .left');
        var price_right = $('.top .price .right');
        var price_value = parseFloat(price_left.html() + '.' + price_right.html());

        var price_left_ingredient = $(this).parent().parent().find('.price .left');
        var price_right_ingredient = $(this).parent().parent().find('.price .right');
        var price_value_ingredient = parseFloat(price_left_ingredient.html() + '.' + price_right_ingredient.html());

        price_value *= 1000000;
        price_value_ingredient *= 1000000;
        var new_price = price_value + price_value_ingredient;
        new_price /= 1000000;
        var new_price = new_price.toString().split(/\./);
        if(new_price.length == 1) {
            new_price.push('00');
        }
        if(new_price[1].length == 1)
            new_price[1] += '0';
        new_price[1] = new_price[1].substr(0, 2);

        price_left.html(new_price[0]);
        price_right.html(new_price[1]);

        // ingredients
        var ingredients = $('.top .ingredients');
        var ingredients_values = $('.top .ingredients .value');

        var ingredient_value = $(this).parent().parent().find('.name').find('span').first().html();

        if(ingredients_values.length == 0) {
            ingredients.append('<span class="value">' + ingredient_value + '</span>');
        } else {
            var has = false;
            for(var i = 0; i < ingredients_values.length; i++) {
                if(ingredients_values[i].innerHTML == ingredient_value) {
                    has = true;
                }
            }
            if(!has)
                ingredients.append('<span class="value">' + ingredient_value + '</span>');
        }
    });

    $('.category .title').click(function(event) {
        $(this).parent().find('.ingredients').slideToggle();
        var dropdown = $(this).find('.dropdown');
        if(dropdown.attr('data-state') == 0) {
            $(this).find('.dropdown').css('transform', 'rotate(225deg)');
            dropdown.css('top', 5);
            dropdown.attr('data-state', 1);
        } else {
            dropdown.css('top', 0);
            $(this).find('.dropdown').css('transform', 'rotate(45deg)');
            dropdown.attr('data-state', 0);
        }
    });

    $('.selected').click(function(event) {
        $('.select .context').slideToggle();
        if($('.arrow').attr('data-state') == 0) {
            $('.arrow').css('transform', 'rotate(45deg)');
            $('.arrow').css('top', 6);
            $('.arrow').attr('data-state', 1);
        } else {
            $('.arrow').css('transform', 'rotate(225deg)');
            $('.arrow').css('top', 0);
            $('.arrow').attr('data-state', 0);
        }
    });

    $('.select .context div').click(function(event) {
        $('.select .context').slideUp();
        $('.arrow').css('transform', 'rotate(45deg)');
        $('.arrow').css('top', 6);
        $('.arrow').attr('data-state', 0);

        $('[data-size]').html($(this).html());
        $('.top .weight .value').html($(this).find('[data-weight]').val());

        // price

        var price_left = $('.top .price .left');
        var price_right = $('.top .price .right');
        var price_hidden = $(this).find('[data-price]');

        var price_new = $(this).find('[data-price]');

        var prices = price_new.val().toString().split(/\./);
        if(prices.length == 1) {
            prices.push('0');
        }

        if(prices[1] == 0)
            prices[1] = '00';
        else if(prices[1] <= 9)
            prices[1] = '0' + prices[1];

        price_hidden.val(prices[0] + '.' + prices[1]);
        $('.action .count span').html('0');
        price_left.html(prices[0]);
        price_right.html(prices[1]);

        $('[data-type="size"]').val($(this).find('[data-type="sizes"]').val());
    });

    $('#order_pizza').click(function(event) {
        var items = $('.category .ingredients .item');

        var ingredients = [];
        var size = $('[data-type="size"]').val();
        for(var i = 0; i < items.length; i++) {
            var id = $(items[i]).find('[data-type="id"]').val();
            var count = $(items[i]).find('[data-type="count"]').html();
            ingredients.push({
                id: id,
                count: count
            });
        }

        $.ajax({
            url: '/pizza/order',
            type: 'POST',
            data: {
                size: size,
                ingredients: ingredients,
            },
            success: function (result, status, xhr) {
                console.log(result);

                $('#amount_text').html(parseInt($('#amount_text').html()) + 1);
                $('#price_text').html((parseFloat($('#price_text').html()) + result.pizza.price).toFixed(2));

                $('#basket_amount').html(parseInt($('#basket_amount').html()) + 1);

                var old_price = parseFloat($('#basket_price').html() + '.' + $('#basket_cent').html());
                var new_price = result.pizza.price;
                old_price *= 1000000;
                new_price *= 1000000;
                var prices = old_price + new_price;
                prices /= 1000000;
                prices = prices.toFixed(2);
                prices = prices.toString().split(/\./);
                if(prices.length == 1)
                    prices.push('0');
                console.log(prices);
                $('#basket_price').html(prices[0]);
                $('#basket_cent').html(prices[1]);
                //$('#basket').html($('#basket').html() + ' ' + result.pizza_view.toString());
                $('#basket').prepend(result.pizza_view.toString());

                $('[data-id="pizza-minus"]').click(function(event) {
                    console.log('pizza-minus');
                    pizza_minus(this)
                });

                $('[data-id="pizza-plus"]').click(function(event) {
                    console.log('pizza-plus');
                    pizza_plus(this);
                });

                $('[data-id="pizza-remove"]').click(function(event) {
                    console.log('pizza-remove');
                    pizza_remove(this);
                });
            },
            error: function (result, status, xhr) {

            }
        });

    });
});

function category_filter(element, event) {
    var data = $('#form_filter').serialize();

    $.ajax({
        "url"     : "/new-category/products",
        "type"    : "post",
        "data"    : data,
        "success" : function (result, status, xhr) {
            console.log(result.product_view);
            $('#products').html(result.product_view);
        },
        "error"   : function (result, status, xhr) {

        }
    });
}

function product_order(target) {
    var product_id = $(target).find('[data-id="product-id"]').val();

    $.ajax({
        url: '/newsite/order',
        type: 'POST',
        data: {
            id: product_id,
        },
        success: function (result, status, xhr) {
            console.log('product-order success');

            if(result.is_new) {
                $('#basket').append(result.product_view);
            } else {
                var item = $('[data-id="product-id-value"][value="' + result.id + '"]').parent();
                var basketItem = new BasketItem();
                basketItem.setContainer(item);
                basketItem.setCount(result.count);
                basketItem.setPrice(result.price);
                basketItem.render();
            }

            $('[data-id="product-minus"]').click(function(event) {
                console.log('product-minus');
                product_minus(this);
            });

            $('[data-id="product-plus"]').click(function(event) {
                console.log('product-plus');
                product_plus(this);
            });

            $('[data-id="product-remove"]').click(function(event) {
                console.log('product-remove');
                product_remove(this);
            });

            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('product-order error');
        }
    });
}

function product_minus(target) {
    var basketItem = new BasketItem();
    basketItem.setContainer($(target).parent().parent().parent());

    $.ajax({
        url: '/newsite/minus',
        type: 'POST',
        data: {
            id: basketItem.getId(),
        },
        success: function (result, status, xhr) {
            console.log('product-minus success');

            basketItem.setCount(result.count);
            basketItem.setPrice(result.price);

            basketItem.render();

            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('product-minus error');
        }
    });
}

function product_plus(target) {
    var basketItem = new BasketItem();
    basketItem.setContainer($(target).parent().parent().parent());

    $.ajax({
        url: '/newsite/plus',
        type: 'POST',
        data: {
            id: basketItem.getId(),
        },
        success: function (result, status, xhr) {
            console.log('product-plus success');

            basketItem.setCount(result.count);
            basketItem.setPrice(result.price);

            basketItem.render();

            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('product-plus error');
        }
    });
}

function product_remove(target) {
    var basketItem = new BasketItem();
    basketItem.setContainer($(target).parent().parent().parent());

    $.ajax({
        url: '/newsite/remove',
        type: 'POST',
        data: {
            id: basketItem.getId(),
        },
        success: function (result, status, xhr) {
            console.log('product-remove success')
            //var item = $('[data-id="product-id-value"][value="' + result.id + '"]').parent().remove()
            var item = $(target).parent().parent();
            item.remove();

            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('product-order error');
        }
    });
}

function pizza_minus(target) {
    var container = $(target).parent().parent().parent();

    $.ajax({
        url: '/pizza/minus',
        type: 'POST',
        data: {
            id: container.find('[data-id="pizza-id-value"]').val(),
            order_id: container.find('[data-id="pizza-order-id-value"]').val(),
            count: container.find('[data-id="pizza-count-value"]').val(),
            price: container.find('[data-id="pizza-price-value"]').val(),
        },
        success: function (result, status, xhr) {
            console.log('minus success');
            console.log(result);

            container.find('[data-id="pizza-count-value"]').val(result.pizza.count);
            var currency = new Currency(result.pizza.price);
            container.find('[data-id="pizza-price-value"]').val(currency.getCurrency());
            container.find('[data-id="pizza-count"]').val(result.pizza.count);
            currency = new Currency(result.pizza.price * result.pizza.count);
            container.find('[data-id="pizza-price-left"]').html(currency.getLeftSide());
            container.find('[data-id="pizza-price-right"]').html(currency.getRightSide());
            
            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('minus error');
        }
    });
}

function pizza_plus(target) {
    
    var container = $(target).parent().parent().parent();

    $.ajax({
        url: '/pizza/plus',
        type: 'POST',
        data: {
            id: container.find('[data-id="pizza-id-value"]').val(),
            order_id: container.find('[data-id="pizza-order-id-value"]').val(),
            count: container.find('[data-id="pizza-count-value"]').val(),
            price: container.find('[data-id="pizza-price-value"]').val(),
        },
        success: function (result, status, xhr) {
            console.log('plus success');
            console.log(result);

            container.find('[data-id="pizza-count-value"]').val(result.pizza.count);
            var currency = new Currency(result.pizza.price);
            container.find('[data-id="pizza-price-value"]').val(currency.getCurrency());
            container.find('[data-id="pizza-count"]').val(result.pizza.count);
            currency = new Currency(result.pizza.price * result.pizza.count);
            container.find('[data-id="pizza-price-left"]').html(currency.getLeftSide());
            container.find('[data-id="pizza-price-right"]').html(currency.getRightSide());
            
            var basket = new Basket();
            basket.setCount(basket.getCount());
            basket.setPrice(basket.getPrice());
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('plus error');
        }
    });
}

function pizza_remove(target) {
    var container = $(target).parent().parent();
    console.log(container);
    $.ajax({
        url: '/pizza/remove',
        type: 'POST',
        data: {
            order_id: container.find('[data-id="pizza-order-id-value"]').val(),
        },
        success: function (result, status, xhr) {
            console.log('pizza-remove success')
            console.log(result);
            container.remove();
            
            var basket = new Basket();
            basket.render();
        },
        error: function (result, status, xhr) {
            console.log('pizza-remove error');
        }
    });
}

function modal_thanks_close(target) {
    $(target).parent().parent().parent().hide();
}

/*
 * class Basket
 */
function Basket() {
    // fields
    this.count = 0;
    this.price = 0;

    this.countIds = null;
    this.priceIds = null;

    // constructor

    if(arguments.length == 0) {
        this.countIds = [
            '#basket-count',
            '#header-count'
        ];
        this.priceIds = [
            '#basket-price',
            '#header-price'
        ];
    }

    // methods

    this.getCount = function() {
        this.count = 0;

        var items = $('[data-id="product-count-value"]');
        for(var i = 0; i < items.length; i++) {
            this.count += parseInt($(items[i]).val());
        }

        var items = $('[data-id="pizza-count-value"]');
        for(var i = 0; i < items.length; i++) {
            this.count += parseInt($(items[i]).val());
        }

        var currency = new Currency(this.count);
        
        return currency.getLeftSide();
    }

    this.getPrice = function() {
        this.price = 0;

        var items = $('[data-id="product-price-value"]');
        for(var i = 0; i < items.length; i++) {
            this.price += parseFloat($(items[i]).val());
        }

        var items = $('[data-id="pizza-price-value"]');
        for(var i = 0; i < items.length; i++) {
            this.price += parseFloat($(items[i]).val());
        }

        var currency = new Currency(this.price);

        return currency.getCurrency();
    }

    this.setCount = function (value) {
        value = parseInt(value);
        if(isNaN(value))
            throw new Error('Basket.setBasketCount(value): the value is not a integer');
        for(var i = 0; i < this.countIds.length; i++) {
            $(this.countIds[i]).val(value);
        }
    }

    this.setPrice = function (value) {
        value = parseFloat(value);
        if(isNaN(value))
            throw new Error('Basket.setBasketCount(value): the value is not a float');
        var currency = new Currency();
        currency.setCurrency(value);
        for(var i = 0; i < this.priceIds.length; i++) {
            $(this.priceIds[i]).val(currency.getCurrency());
        }
    }

    this.render = function() {
        this.count = 0;
        this.price = 0;
        
        var counts = $('[data-id="pizza-count-value"]');
        var prices = $('[data-id="pizza-price-value"]');
        
        for(var i = 0; i < counts.length; i++) {
            this.count += parseFloat(counts[i].value);
            this.price += parseFloat(prices[i].value) * parseFloat(counts[i].value);
        }
        
        var counts = $('[data-id="product-count-value"]');
        var prices = $('[data-id="product-price-value"]');
        
        for(var i = 0; i < counts.length; i++) {
            this.count += parseFloat(counts[i].value);
            this.price += parseFloat(prices[i].value) * parseFloat(counts[i].value);
        }
        
        $('#basket-count').val(this.count);
        $('#basket-price').val(this.price);
        $('#header-count').val(this.count);
        $('#header-price').val(this.price);
        
        var intValue = this.count;
        $('#basket_amount').html(intValue);
        $('#amount_text').html(intValue);

        var currency = new Currency();
        currency.setCurrency(this.price);
        $('#price_text').html(currency.getCurrency());
        $('#basket_price').html(currency.getLeftSide());
        $('#basket_cent').html(currency.getRightSide());

        if(this.count == 0) {
            $('#checkout').slideUp();
        }
    }
}

/**
 * class BasketItem
 */
function BasketItem() {
    // fields
    this.container = null;
    this.id = null;
    this.count = null;
    this.price = null;

    // constructor

    // methods

    this.setContainer = function(container) {
        this.container = container;

        this.id = this.container.find('[data-id="product-id-value"]');
        this.count = this.container.find('[data-id="product-count-value"]');
        this.price = this.container.find('[data-id="product-price-value"]');
    }

    this.getId = function () {
        return this.id.val();
    }

    this.setCount = function(value) {
        value = parseInt(value);
        if(isNaN(value))
            throw new Error();
        this.count.val(value);
    }

    this.setPrice = function(value) {
        var currency = new Currency(value);
        this.price.val(currency.getCurrency());
    }

    this.render = function() {
        this.container.find('[data-id="product-minus"]').val(this.count.val());
        var priceCurrency = new Currency(this.price.val());
        var countCurrency = new Currency(this.count.val());
        priceCurrency = priceCurrency.multiply(countCurrency);
        this.container.find('[data-id="product-count"]').val(countCurrency.getLeftSide());
        this.container.find('[data-id="product-price-left"]').html(priceCurrency.getLeftSide());
        this.container.find('[data-id="product-price-right"]').html(priceCurrency.getRightSide());
    }
}

/**
 * class Currency
 */
function Currency() {
    // fields
    this.original = 0;

    // constructor
    if(arguments.length >= 1) {
        var number = parseFloat(arguments[0]);
        if(isNaN(number))
            throw new Error('Currency.setCurrency(number): the number parameter is not a number');
        this.original = number;
    }

    // methods
    this.setCurrency = function (number) {
        if(number === null || number === undefined || isNaN(number)) {
            throw new Error('Currency.setCurrency(number): the number parameter is not a number');
        }
        this.original = number;
    }

    this.getCurrency = function () {
        return parseFloat(this.original).toFixed(2);
    }

    this.getLeftSide = function () {
        var array = this.getCurrency().split(/\./);
        if(array.length == 0)
            throw new Error('Currency.getLeftSide(): the number parameter is not a number');
        return array[0];
    }

    this.getRightSide = function () {
        var array = this.getCurrency().split(/\./);
        if(array.length == 0)
            throw new Error('Currency.getRightSide(): the number parameter is not a number');
        if(array.length == 1)
            array[1] = 0;
        return array[1];
    }

    this.plus = function(currency) {
        if(!(currency instanceof Currency))
            throw new Error('Currency.plus(currency): the currency is not a class of Currency');
        var bignumber = 100000000;
        var currencyNumber = parseFloat(currency.getCurrency()) * bignumber;
        var thisNumber = this.original * bignumber;
        var result = currencyNumber + thisNumber;
        result /= bignumber;
        var currency = new Currency();
        currency.setCurrency(result);
        return currency;
    }

    this.minus = function(currency) {
        if(!(currency instanceof Currency))
            throw new Error('Currency.minus(currency): the currency is not a class of Currency');
        var bignumber = 100000000;
        var currencyNumber = parseFloat(currency.getCurrency()) * bignumber;
        var thisNumber = this.original * bignumber;
        var result = thisNumber - currencyNumber;
        result /= bignumber;
        var currency = new Currency();
        currency.setCurrency(result);
        return currency;
    }

    this.multiply = function(currency) {
        if(!(currency instanceof Currency))
            throw new Error();
        var result = (parseFloat(this.original) * parseFloat(currency.getCurrency())).toFixed(2);
        var resultCurrency = new Currency(result);
        return resultCurrency;
    }

    this.divide = function(currency) {
        if(!(currency instanceof Currency))
            throw new Error();
        var result = (parseFloat(this.original) / parseFloat(currency.getCurrency())).toFixed(2);
        var resultCurrency = new Currency(result);
        return resultCurrency;
    }
}