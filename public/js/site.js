(function($){
    $(function(){
        //if($('.dotted-title').length) {
        //    $('.dotted-title').each(function () {
        //        var w = $(this).width();
        //        var wc = $(this).children('span').width();
        //        $(this).children('i').css('width',(w-wc)/2-40 );
        //    })
        //}
        (function phs(){
            var op = $('#phone_slider > div.v');
            op.removeClass('v').fadeOut(300);
            if(op.next().length){
                op.next().addClass('v').fadeIn(300);
            }else{
                op.parent().children().first().addClass('v').fadeIn(300);
            }
            setTimeout(phs,1500);
        }());

        $('#form_filter input[type=checkbox]').on('change',function(){
            filter();
        });
        $('#form_filter #select').on('change', function() {
            filter()
        });

        $("#show_ext_form").on('click', function() {
            $(this).toggleClass('active');
            $('.user-data .ext').slideToggle(300);
        });

        phonemask();

        $('#callback').click(function (e) {
            e.preventDefault();
			/*window.yaCounter37864800.reachGoal('CLICK_CALL_BACK', function() {
					console.log('CLICK_CALL_BACK');
				});*/
            var h = '<form id="callback_form">' +
                '<div>' +
                '<input name="name" type="text" placeholder="Ваше имя" value="" required>' +
                '</div>' +
                '<div>' +
                '<input name="phone" type="text" placeholder="Телефон" class="phone" value="" required>' +
                '</div>' +
                '<div>' +
                '<button type="submit">Жду звонка!</button>' +
                '</div>' +
                '</form>';
            $.colorbox({
                html:h,
                onComplete: phonemask
            });
        });
		
		if($("#button_search").length) {
			$("#button_search").click(function(event) {
				/*
				window.ga('send', 'event', 'SEARCH', 'SEARCH', {
					hitCallback: function() {
						console.log('GOOGLE SEARCH');
					}
				});
				window.yaCounter37864800.reachGoal('SEARCH', function() {
					console.log('SEARCH');
				});
				*/
			});
		}
		
		if($("#select").length) {
			$("#select").change(function(event) {
				/*
				window.ga('send', 'event', 'HOME', 'SORT', {
					hitCallback: function() {
						console.log('GOOGLE SORT');
					}
				});
				window.yaCounter37864800.reachGoal('SORT', function() {
					console.log('SORT');
				});
				*/
			});
		}
		
		if($("#instagram").length) {
			$("#instagram").click(function(event) {
				/*
				window.ga('send', 'event', 'HOME', 'INSTAGRAMM', {
					hitCallback: function() {
						console.log('GOOGLE INSTAGRAMM');
					}
				});
				window.yaCounter37864800.reachGoal('INSTAGRAMM', function() {
					console.log('INSTAGRAMM');
				});
				*/
			});
		}
		
		if($("#vk").length) {
			$("#vk").click(function(event) {
				/*
				window.ga('send', 'event', 'HOME', 'VK', {
					hitCallback: function() {
						console.log('GOOGLE VK');
					}
				});
				window.yaCounter37864800.reachGoal('VK', function() {
					console.log('VK');
				});
				*/
			});
		}
		
		if($("#facebook").length) {
			$("#facebook").click(function(event) {
				/*
				window.ga('send', 'event', 'HOME', 'FB', {
					hitCallback: function() {
						console.log('GOOGLE FB');
					}
				});
				window.yaCounter37864800.reachGoal('FB', function() {
					console.log('FB');
				});
				*/
			});
		}

        $('body').on('submit','#callback_form', function (e) {
            e.preventDefault();
			/*
			window.yaCounter37864800.reachGoal('CALL_BACK', function() {
					console.log('CALL_BACK');
			});
			window.ga('send', 'event', 'HOME', 'CALL_BACK', {
					hitCallback: function() {
						console.log('GOOGLE CALL_BACK');
					}
			});
			*/
            var form = $(this);
            $.ajax({
                type: 'POST',
                url:"/feedback",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    data  : decodeURI(form.serialize()),
                    contentType: "application/x-www-form-urlencoded;charset=utf-8",
                },
                beforeSend: function () {
                    form.find('button').prop('disabled',true);
                },
                success: function() {
                    form.find('button').prop('disabled',false);
					try {
						window.ga('send', 'event', 'HOME', 'CALL_BACK');
					} catch(e) {}
                    $.colorbox({
                        html:'<form id="callback_form"><p>Ваша заявка принята!</p></form>'
                    })
                }
            });
        });

        $('.show-filter').click(function (e) {
            e.preventDefault();
			/*
			window.ga('send', 'event', 'HOME', 'FILTER', {
					hitCallback: function() {
						console.log('GOOGLE FILTER');
					}
				});
			window.yaCounter37864800.reachGoal('CALL_BACK', function() {
					console.log('FILTER');
			});
			*/
            $(this).toggleClass('open');
            $('#filter').slideToggle(300);
        });

        $('#mobile_menu_toggler').click(function (e) {
            e.preventDefault();
            $('#mobile_menu').addClass('open');
        });
        $('#mobile_menu_overlay,#mobile_menu .close').click(function (e) {
            e.preventDefault();
            $('#mobile_menu').removeClass('open');
        });

        $('#basket_block .close').click(function (e) {
            e.preventDefault();
            $('#basket_block').slideUp(300);
            $('#top, body').removeClass('cart-is-open');
        });
    });

    function phonemask(){
        $('input.phone').inputmask('+38 (999) 999-99-99');
    }

    function filter() {

        /*
        var form = $('input[type=checkbox]');
        $.post(product_url, { _token: token, forms: form.serialize(),
            id: $("#id").val(), 
            select: document.getElementById('select').value
        }, function(result) {
            $('#products').html(result);
        });
        */
    }
})(jQuery);

// ID: PRICE - ONCLICK: BASKET SHOW

function basket_show()
{
    length = parseFloat(document.getElementById('amount_text').innerHTML);
    if(length > 0) {
        $('#basket_block').slideToggle(300);
        $('#top, body').toggleClass('cart-is-open');
    }
}

// function order_click(url, id)
// {
// 	/*window.yaCounter37864800.reachGoal('BASKET', function() {
// 					console.log('BASKET');
// 				});*/
//
//     var ajax = new XMLHttpRequest();
//     ajax.onreadystatechange = function()
//     {
//         if(ajax.readyState == 4 && ajax.status == 200)
//         {
//             var result = JSON.parse(ajax.responseText);
//
//             price = Math.round(result.price);
//             var cent = result.cent.toString().substr(2);
//             if(cent < 10)
//                 cent = '0' + cent;
//             else if(cent == 0)
//                 cent = '00';
//             var basket = result.basket;
//             var amount = result.amount;
//
//             document.getElementById('price_text').innerHTML = price + '.' + cent;
//             document.getElementById('basket_price').innerHTML = price;
//             document.getElementById('basket_cent').innerHTML = cent;
//             //document.getElementById('basket').innerHTML = basket;
//             console.log(basket);
//             $('#basket').append(basket);
//             document.getElementById('basket_amount').innerHTML = amount;
//             document.getElementById('amount_text').innerHTML = amount;
//
//             $('#mini_cart').removeClass('added');
//             setTimeout(function () {
//                 $('#mini_cart').addClass('added')
//             },10);
//
//         }
//     };
//     ajax.open('get', (url + '/' + id), true);
//     ajax.send();
// }

// SEARCH AJAX

function text_search_onkeydown(url)
{
    var text_search = document.getElementById('text_search');
    if (text_search.value.length >= 2)
    {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                var result_search = document.getElementById("result_search");
                result_search.innerHTML = ajax.responseText;
            }
        };
        ajax.open("get", url + "/" + decodeURI(text_search.value), true);
        ajax.send();
    }
    else
    {
        var result_search = document.getElementById("result_search");
        result_search.innerHTML = "";
    }
}

// SEARCH

function button_search_onclick(url)
{
    var form_search = document.getElementById('form_search');
    var text_search = document.getElementById('text_search');
    form_search.action = url + '/' + decodeURI(text_search.value);
    form_search.submit();
}

function category_onload(url)
{
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function()
    {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById('nav').innerHTML = ajax.responseText;
        }
    }
    ajax.open('get', url, true);
    ajax.send();
}

/***************************** CATEGORY CHECKBOX MARK **************************/

marks = new Array();

function checkbox_check_mark(element)
{
    checkbox = element.parentElement.getElementsByTagName('input')[0];
	
    if(checkbox.checked != true)
    {
        marks.push(checkbox.value);
    }
    else
    {
        for(var i = 0; i < marks.length; i++)
        {
            if(marks[i] == checkbox.value) {
		marks.splice(i, 1);
                break;
            }
        }
    }
    product_load(product_url);
}

/***************************** CATEGORY CHECKBOX INGREDIENT **********************/

ingredients = new Array();

function checkbox_check_ingredient(element)
{
    checkbox = element.parentElement.getElementsByTagName('input')[0];
	
    if(checkbox.checked != true)
    {
        ingredients.push(checkbox.value);
    }
    else
    {
        for(var i = 0; i < ingredients.length; i++)
        {
            if(ingredients[i] == checkbox.value) {
                ingredients.splice(i, 1);
                break;
            }
        }
    }
    product_load(product_url);
}

/*********************** CATEGORY WEIGHT ****************************/

selectWeight = 0;

function select_weight(element)
{
	selectWeight = element.value;
	product_load(product_url);
}

/*********************** CATEGORY PRICE ****************************/

selectPrice = 0;

function select_price(element)
{
	selectPrice = element.value;
	product_load(product_url);
}

/*********************** CATEGORY WEIGHT ****************************/

selectPopular = 0;

function select_popular(element)
{
	selectPopular = element.value;
	product_load(product_url);
}

/*********************** CATEGORY PRODUCT ***************************/

function product_load(url) {
    var ajax = new XMLHttpRequest();
    params = '_token=' + token;
    params += '&id=' + window.location;
    params += '&marks=';
    more1 = false;
    for(var i = 0; i < marks.length; i++)
    {
        if(marks[i] != null) {
            more1 = true;
            break;
        }
    }
    if (more1)
    {
        for (var i = 0; i < marks.length; i++) {
            params += marks[i] + ';';
        }
    }
    else {
        params += 'null'
    }
    params += '&ingredients=';
    more1 = false;
    for(var i = 0; i < ingredients.length; i++)
    {
        if(ingredients[i] != null) {
            more1 = true;
            break;
        }
    }
    if(more1) {
        for (var i = 0; i < ingredients.length; i++) {
            params += ingredients[i] + ';';
        }
    }
    else {
        params += 'null';
    }
	params += '&weight=' + selectWeight;
	params += '&price=' + selectPrice;
	params += '&popular=' + selectPopular;
    ajax.onreadystatechange = function() {
        if(ajax.readyState == 4 && ajax.status == 200)
        {
            document.getElementById('products').innerHTML = ajax.responseText;
        }
    }
    ajax.open('post', url, true);
    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    ajax.send(params);
}

/************************** BASKET BUTTON REMOVEL ***************************/
//
// function basketremove_click(url)
// {
// 	/*
// 	window.ga('send', 'event', 'BASKET', 'DEL', {
// 					hitCallback: function() {
// 						console.log('GOOGLE DEL');
// 					}
// 				});
// 	window.yaCounter37864800.reachGoal('DEL', function() {
// 					console.log('DEL');
// 				});
// 	*/
//     var ajax = new XMLHttpRequest();
//     ajax.onreadystatechange = function()
//     {
//         if(ajax.readyState == 4 && ajax.status == 200)
//         {
//             var result = JSON.parse(ajax.responseText);
//
//             document.getElementById('price_text').innerHTML = result.price + '.' + result.cent;
//             document.getElementById('basket_price').innerHTML = result.price;
//             document.getElementById('basket_cent').innerHTML = result.cent;
//             document.getElementById('basket').innerHTML = result.basket;
//             document.getElementById('basket_amount').innerHTML = result.amount;
//             document.getElementById('amount_text').innerHTML = result.amount;
//
//             if(parseInt(result.amount) == 0) {
//                 $('#basket_block').slideUp(1000);
//                 $('#top, body').removeClass('cart-is-open');
//             }
//
//         }
//     }
//     ajax.open('get', url, true);
//     ajax.send();
// }

/************************** BASKET BUTTON MINUS *****************************/

// function basketminus_click(url)
// {
//     var ajax = new XMLHttpRequest();
//     ajax.onreadystatechange = function()
//     {
//         if(ajax.readyState == 4 && ajax.status == 200)
//         {
//             var result = JSON.parse(ajax.responseText);
//
//             document.getElementById('price_text').innerHTML = result.price + '.' + result.cent;
//             document.getElementById('basket_price').innerHTML = result.price;
//             document.getElementById('basket_cent').innerHTML = result.cent;
//             document.getElementById('basket').innerHTML = result.basket;
//             document.getElementById('basket_amount').innerHTML = result.amount;
//             document.getElementById('amount_text').innerHTML = result.amount;
//
//         }
//     }
//     ajax.open('get', url, true);
//     ajax.send();
// }

/************************** BASKET BUTTON PLUS *****************************/

// function basketplus_click(url)
// {
//     var ajax = new XMLHttpRequest();
//     ajax.onreadystatechange = function()
//     {
//         if(ajax.readyState == 4 && ajax.status == 200)
//         {
//             var result = JSON.parse(ajax.responseText);
//
//             price = Math.round(result.price);
//             var cent = result.cent.toString().substr(2);
//             if(cent < 10)
//                 cent = '0' + cent;
//             else if(cent == 0)
//                 cent = '00';
//             var basket = result.basket;
//             var amount = result.amount;
//
//             document.getElementById('price_text').innerHTML = price + '.' + (cent < 10 ? '0' + cent : cent);
//             document.getElementById('basket_price').innerHTML = price;
//             document.getElementById('basket_cent').innerHTML = (cent < 10 ? '0' + cent : cent);
//             document.getElementById('basket').innerHTML = basket;
//             document.getElementById('basket_amount').innerHTML = amount;
//             document.getElementById('amount_text').innerHTML = amount;
//         }
//     }
//     ajax.open('get', url, true);
//     ajax.send();
// }

/************************ PHONE SLIDER **************************/

_phone_slider = document.getElementById('phone_slider');
function phone_slider()
{
    slider_image1();
}

function slider_image1()
{
    $('#slider_image1').slideDown(500);
    $('#slider_image2').css('display', 'none');
    $('#slider_image3').css('display', 'none');

    setTimeout(slider_image2, 3000);
}

function slider_image2()
{
    $('#slider_image1').css('display', 'none');
    $('#slider_image2').slideDown(500);
    $('#slider_image3').css('display', 'none');

    setTimeout(slider_image3, 3000);
}

function slider_image3()
{
    $('#slider_image1').css('display', 'none');
    $('#slider_image2').css('display', 'none');
    $('#slider_image3').slideDown(500);

    setTimeout(slider_image1, 3000);
}

phone_slider();

/*************************** BASKET SUBMIT **************************/

function basket_phone_onkeydown()
{
    var key = String.fromCharCode(event.keyCode);
    if(/[0-9\+]{1}/.test(key) || event.keyCode == 8)
        return true;
    else
        return false;
}

/*************************** MAIN SEARCH ***************************/

function search_text_onkeyup(url)
{
    if(event.altKey || event.ctrlKey || event.shiftKey)
        return;

    switch(event.keyCode)
    {
        case 8:
            return;
        case 46:
            return;
    }
    if(document.getElementById('search_text').value.length < 3)
        document.getElementById('search_help').style.display = "none";

    else {
        document.getElementById('search_help').style.display = "inline-block";

        try {
            var params = '_token=' + token;
            params += '&text=' + document.getElementById('search_text').value;

            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function () {
                if (ajax.responseText == "null") {
                    document.getElementById('search_help').innerHTML = "";
                }
                else {
                    document.getElementById('search_help').innerHTML = ajax.responseText;
                }
            }
            ajax.open('post', url, true);
            ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded;charset=utf-8');
            ajax.send(params);
        }
        catch (e) {
            document.getElementById('search_help').innerHTML = "";
        }
    }
}

function search_post(url)
{
    var search_hidden = document.getElementById('search_hidden');
    var search_text = document.getElementById('search_text');
    var search_form = document.getElementById('search_form');
    search_hidden.value = search_text.value;
    search_form.submit();
}

/*********************** ЕЩЕ *****************************/

else_count = 4;

function else_onclick(url)
{
    else_count += 3;
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function () {
        if(ajax.readyState == 4 && ajax.status == 200) {
            var obj = JSON.parse(ajax.responseText);
            if(obj.enough)
                document.getElementById('else_separator').style.display = 'none';
            document.getElementById('else').innerHTML = obj.else_content;
        }
    }
    ajax.open('get', url + '/' + else_count, true);
    ajax.send();
    return false;
}

function basket_submit(url)
{
/*
	window.yaCounter37864800.reachGoal('ORDER', function() {
					console.log('ORDER');
				});
	window.ga('send', 'event', 'BASKET', 'ORDER', {
		hitCallback: function() {
			console.log('GOOGLE ORDER');
		}
	});
	*/

    var basket_name = document.getElementById("basket_name");
    if(basket_name.value.length == 0)
    {
		$.colorbox({
                        html: "<div class='alert'><p>Введите имя!</p></div>",
                        width:300,
                        height:100
                    });
        return false;
    }
    var basket_phone = document.getElementById("basket_phone");
    if(basket_phone.value.length == 0)
    {
		$.colorbox({
                        html: "<div class='alert'><p>Введите телефон!</p></div>",
                        width:300,
                        height:100
                    });
        return false;
    }
	/*
	var info = document.getElementById("info");
	if(!info.checked)
	{
		$.colorbox({
                        html: "<p class='alert'>Нужно согласится с правилами!</p>",
                        width:300,
                        height:100
                    });
        return false;
    }
	*/

    if($('#show_ext_form').attr('class') == 'active') {
        var select = $('#checkout .user-data .address select[name="city"]');
        if(select.val() == -1) {
            $.colorbox({
                "html": "<p style='text-align: center; height: 60px;'>Вы не выбрали город!</p>"
            });
            return;
        }
    }

    var ajax = new XMLHttpRequest();
    var params = "_token=" + $('meta[name=csrf-token]').attr('content');
	params += "&" + $("#form_basket").serialize();

    ajax.onreadystatechange = function () {
        if(ajax.readyState == 1){
            $('#basket_submit_button').prop('disabled',true).html('<i></i>');
        }
        if(ajax.readyState == 4){
            $('#basket_submit_button').prop('disabled',false).text('оформить заказ');
        }
        if(ajax.readyState == 4 && ajax.status == 200) {
            var result = JSON.parse(ajax.responseText);
            if(result.status == true)
            {
                var googleAnalytics = new GoogleAnalytics();
                googleAnalytics.load();
                for(var item in result.dataGoogle) {
                    googleAnalytics.add(item.id, item.name, item.price, item.quantity);
                }
                googleAnalytics.send();
                if(result.lp == '1'){
                    $('body').append(result.pay).find('#lp_form').trigger('submit');
                }else{

                    document.getElementById('price_text').innerHTML = result.price + '.' + result.cent;
                    document.getElementById('basket_price').innerHTML = result.price;
                    document.getElementById('basket_cent').innerHTML = result.cent;
                    document.getElementById('basket').innerHTML = result.basket;
                    document.getElementById('basket_amount').innerHTML = result.amount;
                    document.getElementById('amount_text').innerHTML = result.amount;

                    length = document.getElementById('amount_text').innerHTML;

                    if(length == 0)
                        $('#basket_block').slideToggle(1000);

                    var currency = new Currency(result.bonus);
                    $('[data-id="bonus-price-left"]').html(currency.getLeftSide());
                    $('[data-id="bonus-price-right"]').html(currency.getRightSide());
                    $('[data-id="modal-thanks"]').show();
                }
            }
        }
    }
    ajax.open('post', url, true);
    ajax.setRequestHeader('Content-type', 'application/x-www-form-urlencoded;charset=utf-8');
    ajax.send(params);
}

/**
 * class GoogleAnalytics
 */
function GoogleAnalytics () {

    this.is_plugin_loaded = false;

    this.data = [];

    this.load = function() {
        if(!this.is_plugin_loaded) {
            ga('require', 'ecommerce');
            this.is_plugin_loaded = true;
        } else {
            throw new Error('Плагин ecommerce уже загружен!');
        }
    }

    /**
     * @param id: int
     * @param name: string
     * @param price: float
     * @param quantity: int
     * @param currency: string
     */
    this.add = function(id, name, price, quantity) {
        var _id = id;
        var _name = name;
        var _price = price;
        var _quantity = quantity;
        var _currency = 'UAH';
        this.data.push({
            'id': _id,
            'name': name,
            'price': _price,
            'quantity': _quantity,
            'currency': _currency
        });
    }

    this.send = function () {
        if(this.is_plugin_loaded) {
            for(var item in this.data) {
                ga('ecommerce:addItem', item);
            }

            ga('ecommerce:send');

            console.log(ga);
            console.log('GoogleAnalytics sended');
        } else {
            throw new Error('Не загружен плагин ecommerce. Невозможно отправить данные на сервер!');
        }
    }

    this.clear = function() {
        if(this.is_plugin_loaded) {
            this.data = [];

            ga('ecommerce:clear');

            console.log('GoogleAnalytics cleared');
        } else {
            throw new Error('Не загружен плагин ecommerce. Невозможно удалить данные с сервер!');
        }
    }
}