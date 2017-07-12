<?php

    $categories = \App\Models\Category::where('show', 1)->orderBy('position')->get();
	\View::share('categories',$categories);
?>

<?php
    $many_pizza = \App\Modules\Pizza::getPizza();
    $price_pizza = 0;
    $pizza_amount = 0;
    foreach ($many_pizza as $pizza) {
        $pizza_amount += $pizza->count;
        $price_pizza += $pizza->price * $pizza->count;
    }
    $prices = \App\Modules\Price::getPrice($price_pizza);
    $price += $prices->left;
    $cent += $prices->right;
    $amount += $pizza_amount;
?>

<header>
	<section id="top">
		<div class="wrap">
			<div class="left clearfix">
				<a href="{{ url('promos') }}" class="promos">Акции</a>
				<a href="{{ url('search') }}" class="search"><i class="icon-search"></i></a>
			</div>

            <a href="javascript:void(0)" id="mini_cart" class="right" onclick="basket_show()">
				<input type="hidden" name="header-count" id="header-count" value="{{ $amount }}">
				<input type="hidden" name="header-price" id="header-price" value="{{ $price . '.' . $cent }}">
				<span class="prod-count"><span id="amount_text">{{ $amount }}</span><i class="icon-cart"></i></span>
				<span class="sum" id="price_text">{{ $price }}.{{ $cent }}</span>
			</a>

			<div class="center">
				<div class="phones clearfix">
                                <div class="country-code">+38</div>
                                <div class="operators" id="phone_slider">
                                    <div><i class="icon-ks"></i><span>097</span></div>
                                    <div><i class="icon-mts"></i><span>095</span></div>
                                    <div class="v"><i class="icon-lifecell"></i><span>093</span></div>
                                </div>
				<div class="number"> 257 33 77</div>
				</div>
				<a href="#" id="callback" onclick="yaCounter37864800.reachGoal('CLICK_CALL_BACK'); return true;">обратный звонок</a>
			</div>
		</div>
	</section>
	<div id="top_gap"></div>

	<section id="hat">
		<div class="wrap">
            <div class="center">
                <div class="logo center">
                    @if(url()->current() != url('/'))
                        <a href="{{ url('/') }}"></a>
                    @endif
                </div>
            </div>
			<div class="right">
				<div class="delivery">
					<div class="free">
						<div><span>Бесплатная</span>доставка</div>
						<i class="icon-shipping"></i>
					</div>
					<div class="schedule">
					<?php
						/*
						$day_of_week = \Carbon\Carbon::now()->dayOfWeek;
						$time_of_day = \Carbon\Carbon::now()->hour;
						//echo "<script>console.log('$day_of_week' + ' ' + '$time_of_day');</script>";
						if($day_of_week == 4 || $day_of_week == 5 || $day_of_week == 6) {
							if($day_of_week == 4 && $time_of_day > 10) {
								echo 'Заказы принимаем курглосуточно';
							} else {
								echo 'Заказы принимаем с 10:00 до 22:00';
							}
							if($day_of_week == 5) {
								echo 'Заказы принимаем курглосуточно';
							}
							if($day_of_week == 6 && $time_of_day > 10) {
								echo 'Заказы принимаем с 10:00 до 22:00';
							}
						} else {
							echo 'Заказы принимаем с 10:00 до 22:00';
						}
						*/
					?>
					<!--Заказы принимаем с 10:00 до 22:00-->
					</div>
				</div>
			</div>
            <div class="left">
                <div class="shares">
                    <div class="sbtns">
                        <a onclick="ga('send', 'event', 'HOME', 'INSTAGRAMM'); yaCounter37864800.reachGoal('INSTAGRAMM');" id="instagram" href="https://www.instagram.com/_rnr.com.ua_/" rel="nofollow" target="_blank"><i class="icon-sinst"></i></a>
                        <a onclick="ga('send', 'event', 'HOME', 'VK'); yaCounter37864800.reachGoal('VK');" id="vk" href="https://vk.com/rnrcomua" rel="nofollow" target="_blank"><i class="icon-svk"></i></a>
                        <a onclick="ga('send', 'event', 'HOME', 'FB'); yaCounter37864800.reachGoal('FB');" id="facebook" href="https://facebook.com/rnrcomua" rel="nofollow" target="_blank"><i class="icon-sfb"></i></a>
                    </div>
                    <div class="left-info">
                        <span>Узнавайте</span>новости
                    </div>
                    <p>Оставляй отзывы делись впечатлениями</p>
                </div>
            </div>
		</div>
	</section>
	
	<style>
		.take-order {
			text-align: center;
			color: white;
			text-transform: uppercase;
			position: relative;
			top: -15px;
			margin-top: -10px;
		}
		.take-order span {
			font-size: 16px;
			font-style: italic;
			position: relative;
			left: -1px;
		}
		.take-order span sup {
			font-size: 10px;
		}
		.take-order .title {
			color: rgb(255, 156, 0);
		}
		.take-order .left {
			color: rgb(253, 196, 107);
		}
		.take-order .right {
			color: rgb(253, 228, 188);
		}
		@media screen and (max-width: 530px) {
			.take-order span {
				display: block;
			}
		}
	</style>
	<div class="take-order">
		<span class="title">Заказы принимаем: </span>
		<span class="left">вс - ср с 10<sup>00</sup> до 22<sup>00</sup>,</span>
		<span class="right">чт-сб круглосуточно</span>
	</div>

	<nav id="main-menu">
		<div class="wrap">
            <div id="mobile_menu_toggler">
                <span></span>
                <span></span>
                <span></span>
            </div>
			<ul>

			@foreach($categories as $category)
				@if(!$category->is_pizza)
					@if(url('catalog/'.$category->url) == url()->current())
						<li class="active">
							<span>
								<i class="icon-{{ $category->class }} icon2"></i>
								<span>{!! $category->name !!}</span>
							</span>
						</li>
					@else
						<li>
							<a href="{{ url('catalog/'.$category->url) }}">
								<i class="icon-{{ $category->class }} icon2"></i>
								<span>{!! $category->name !!}</span>
							</a>
						</li>
					@endif
				@else
					<li <?php echo url('catalog/'.$category->url) == url()->current() ? 'class="active"' : '' ?>>
						<a href="{{ url('catalog/'.$category->url) }}">
							<i class="icon-pizza icon2"></i>
							<span>{!! $category->name !!}</span>
						</a>
					</li>
				@endif
			@endforeach
			</ul>
		</div>
	</nav>
	
</header>