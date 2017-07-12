<footer>
	<div class="wrap clearfix">
		<div class="left">
			<div class="logo">
				@if(url()->current() != url('/'))
					<a href="{{ url('/') }}"></a>
				@endif
			</div>
			<div class="copy">
				<p class="foot-y">&copy; {{ date('Y') }}</p>
				<p class="foot-br">ROCK & ROLL</p>
			</div>
		</div>

		<div class="right">
			<nav class="footer-nav">
				<ul class="clearfix">
					<li>
						@if(url('about-us') == url()->current())
							<span class="active">О нас</span>
						@else
							<a href="{{ url('about-us') }}">О нас</a>
						@endif
					</li>
					<li>
						@if(url('express') == url()->current())
							<span class="active">Оплата и доставка</span>
						@else
							<a href="{{ url('express') }}">Оплата и доставка</a>
						@endif
					</li>
					<li>
						@if(url('recipes') == url()->current())
							<span class="active">Рецепты наших блюд</span>
						@else
							<a href="{{ url('recipes') }}">Рецепты наших блюд</a>
						@endif
					</li>
					<li>
						@if(url('promos') == url()->current())
							<span class="active">Акции</span>
						@else
							<a href="{{ url('promos') }}">Акции</a>
						@endif
					</li>
					<li>
						@if(url('contacts') == url()->current())
							<span class="active">Контакты</span>
						@else
							<a href="{{ url('contacts') }}">Контакты</a>
						@endif
					</li>
				</ul>
			</nav>

			<nav class="footer-menu clearfix">
				<div class="first">
					<ul>
						@for($i = 0; $i < count($categories) / 2; $i++)
							<li>
								@if(url('catalog/'.$categories[$i]->url) == url()->current())
									<span class="active">
                                        {!! str_replace('<br>',' ',$categories[$i]->name) !!}
									</span>
								@else
									<a href="{{ url('catalog/'.$categories[$i]->url) }}">
                                        {!! str_replace('<br>',' ',$categories[$i]->name) !!}
									</a>
								@endif
							</li>
						@endfor
					</ul>
				</div>
				<div class="second">
					<ul>
						@for($i2 = (count($categories) / 2)+1 ; $i2 < count($categories); $i2++)
							<li>
								@if(url('catalog/' . $categories[$i2]->url) == url()->current())
									<span class="active">
										{!! str_replace('<br>',' ',$categories[$i2]->name) !!}
									</span>
								@else
									<a href="{{ url('catalog/' . $categories[$i2]->url) }}">
										{!! str_replace('<br>',' ',$categories[$i2]->name) !!}
									</a>
								@endif
							</li>
						@endfor
					</ul>
				</div>
				<div class="last">
					<div class="payments">
						<i class="icon-privat24"></i>
						<i class="icon-visa"></i>
						<i class="icon-mastercard"></i>
					</div>
					<div class="copy">
						<a href="http://urkmisto.com.ua/" target="_blank" title="Разработка и поддержка сайта"><img src="{{ url('images/misto.png') }}" alt="urkmisto.com.ua"></a>
					</div>
				</div>

			</nav>

		</div>

	</div>
	<div class="bg-y"></div>
	<div class="bg-b"></div>
</footer>


<noindex>

    <div id="mobile_menu">
        <div class="title">Меню <i class="icon-times close"></i></div>
        <div class="content">
            <ul>
            @foreach($categories as $category)
                @if(url('catalog/'.$category->url) == url()->current())
                    <li class="active">
						<span>
							<i class="icon-{{ $category->class }}" icon2></i>
							<span>{{ str_replace('<br>','',$category->name) }}</span>
						</span>
                    </li>
                @else
                    <li>
                        <a href="{{ url('catalog/'.$category->url) }}">
                            <i class="icon-{{ $category->class }} icon2"></i>
                            <span>{{ str_replace('<br>','',$category->name) }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
            </ul>
        </div>
    </div>
    <div id="mobile_menu_overlay"></div>

</noindex>