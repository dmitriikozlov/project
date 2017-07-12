<section id="checkout">
	<?php

		$many_pizza = \App\Modules\Pizza::getPizza();
		$price_pizza = 0;
		$pizza_amount = 0;
		foreach($many_pizza as $pizza) {
			$pizza_amount += $pizza->count;
                        $price_pizza += $pizza->price * $pizza->count;
		}
		$prices = \App\Modules\Price::getPrice($price_pizza);
		$price += $prices->left;
		$cent += $prices->right;
		$amount += $pizza_amount;
	?>

    <div class="wrap" id="basket_block">
        <div class="container">
            <header class="clearfix">
                <div class="close"><i class="icon-times"></i></div>
                <div class="title">Форма заказа</div>
                <a href="#" id="show_ext_form">РАСШИРЕННАЯ ФОРМА ЗАКАЗА</a>
                <div class="minicart">
                    <input type="hidden" name="basket-count" id="basket-count" value="{{ $amount }}">
                    <input type="hidden" name="basket-price" id="basket-price" value="{{ $price . '.' . $cent }}">
                    <div class="sum-text">Сумма: </div>
                    <div class="prod-count"><span id="basket_amount">{{ $amount }}</span><i class="icon-cart"></i></div>
                    <div class="sum"><label id="basket_price">{{ $price }}</label>.<sup id="basket_cent">{{ $cent }}</sup></div>
                </div>
            </header>
            <form action="#" id="form_basket" class="">
                <div class="products clearfix" id="basket">
					@foreach($many_pizza as $pizza)
						@include('site.pizza.basket-item', [
                            'pizza' => $pizza,
                        ])
					@endforeach
					@foreach($orders as $product)
						@include('site.newsite.basket-item', [
                            'product' => $product,
                        ])
					@endforeach
                </div>
                <div class="user-data clearfix">

	                <div class="title ext nm">
		                Контактные дынные
	                </div>
                    <div class="field name">
                        <input type="text" placeholder="Имя" id="basket_name" name="name" required>
                    </div>

                    <div class="field">
                        <input type="text" placeholder="Телефон" id="basket_phone" name="phone" class="phone" required>
                    </div>

	                <div class="field ext">
		                <input name='email' placeholder="Email" type='email' required>
	                </div>

	                <div class="delivery-time ext">
		                <div class="title">
			                Время доставки
		                </div>
		                <div class="label-row">
			                <label><input name='time' type='radio' value="0" checked>
			                    <span>Доставить в ближайшее время</span>
		                    </label>
		                </div>
		                <div class="label-row">
			                <label>
				                <input name='time' type='radio' value="1">
				                <span>Доставить</span>
			                </label>

			                <select name='time_detail'>
				                <option value='{{ \Carbon\Carbon::now()->format('d.m.Y') }}'>сегодня</option>
				                <option value='{{ \Carbon\Carbon::now()->addDay()->format('d.m.Y') }}'>завтра</option>
				                @for($i = 2; $i <= 5; $i++)
					                <option value="{{ \Carbon\Carbon::now()->addDays($i)->format('d.m.Y') }}">
						                {{ \Carbon\Carbon::now()->addDays($i)->format('d.m.Y') }}
					                </option>
				                @endfor
			                </select>
		                </div>
						<div data-id="datetime" class="label-row">
							<?php
								$now = \Carbon\Carbon::now();
								$now->addMinutes(30);
							?>
							<span>Время доставки</span>
							<input name="datetime" type="text" value="{{ $now->format('H:i') }}">
						</div>
	                </div>
	                <div class="payment ext nm">
		                <div class="title">
			                Способ облаты
		                </div>
		                <select name='pay'>
			                @for($i = 0; $i < count(config('pay')); $i++)
				                <option value='{{ $i }}'>{{ mb_strtolower(config('pay')[$i]) }}</option>
			                @endfor
		                </select>

	                </div>
	                <div class="address ext">
		                <div class="title nm">
			                Адрес доставки
		                </div>
		                <div class="input" style="position: relative">
							<span id="city_span" style="display: inline-block; position: absolute;
							left: 10px; top: 20px; color: gray;">город</span>
							<select name='city'>
								<option value="{{ -1 }}"></option>
								@foreach(config('countries') as $id => $values)
									<option value='{{ $id }}'>{{ $values['title'] }}</option>
								@endforeach
							</select>
							<script>
								$(document).ready(function(event) {
									$("#checkout .user-data .address select").change(function(event) {
										console.log('city');
										if($(this).val() == -1) {
											$('#city_span').css('display', 'inline-block');
										} else {
											$('#city_span').css('display', 'none');
										}
									});
								})
							</script>
		                </div>
		                <div class="input">
		                    <input name='street' placeholder="Улица" type='text'>
		                </div>

		                <div class="input short">
			                <input name='house' placeholder="дом" type='text'>
		                </div>

		                <div class="input short">
			                <input name='flat' placeholder="квартира" type='text'>
		                </div>

		                <div class="input short">
			                <input name='access' placeholder="Подьезд" type='text'>
		                </div>

		                <div class="input short">
			                <input name='floor' placeholder="Этаж" type='text'>
		                </div>
	                </div>


	                <div class="comment ext">
		                <textarea name="comment" placeholder="Коментарий к заказу, например: &laquo;код домофона 345&raquo;" cols="40" rows="7"></textarea>
	                </div>

	                <div class="checks ext">
		                <label class="important">
			                <input name='call' type='checkbox' checked>
			                <span>Перезвонить мне после оформления заказа</span><br>
		                </label>

		                <label class="gray">
			                <input name="info" type="checkbox" checked>
			                <span>Я предоставляю свое согласие на передачу, сбор, обработку, использование, накопление и хранение моих персональных данных с целью их внесения в базу персональных данных контрагентов согласно норм действующего законодательства о защите персональных данных</span>
		                </label>

	                </div>

	                <div class="proceed">
		                <button type="button" id="basket_submit_button" onclick="basket_submit('{{ url('submit') }}'); window.yaCounter37864800.reachGoal('ORDER'); window.ga('send', 'event', 'BASKET', 'ORDER');">оформить заказ</button>
	                </div>
                </div>

            </form>
        </div>
    </div>
</section>