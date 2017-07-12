@extends('site.layout.index')

@section('meta')
	<?php 
		$meta = null;
		if($category) 
			if($category->meta_id != null)
				$meta = \App\Models\Meta::find($category->meta_id);
	?>
	@if($meta != null)
		<title>{{ $meta->title != null ? $meta->title : '' }}</title>
		<meta name="description" content="{{ $meta->title != null ? $meta->description : '' }}" >
		<meta name="keywords" content="{{ $meta->title != null ? $meta->keywords : '' }}" >
		<meta name="robots" content="{{ $meta->title != null ? $meta->robots : '' }}" >
	@endif
@stop

@section('content')

    <section class="category">
        <div class="wrap clearfix">
	        <form id="form_filter" action="{{ url('/new-category/products/') }}" method="post">
                {{ csrf_field() }}
				<input type="hidden" name="category" id="id" value="{{ $category->id }}">
                @if($products)
	             <div class="category-title">
	                <span class="title">{{ str_replace('<br>', ' ', $category->name) }}</span>

                     <span class="show-filter" onclick="window.ga('send', 'event', 'HOME', 'FILTER'); window.yaCounter37864800.reachGoal('FILTER');"><i class="icon-filter"></i></span>

                    <select id="select" name="select" autocomplete="off" onchange="window.yaCounter37864800.reachGoal('SORT');">
                        <option value="6">популярное</option>
                        <option value="5">новинки</option>
                        <option value="1">большой вес</option>
                        <option value="2">маленький вес</option>
                        <option value="3">от дорогих</option>
                        <option value="4">от дешевых</option>


                    </select>

	            </div>
	                <div id="filter" class="clearfix">

                        @foreach($ingredients as $i)
                            <div>
                                <label>
                                    <input type="checkbox" name="ingredients[]"  value="{{ $i->id }}" autocomplete="off"
                                           data-filter="ingredient"
                                           data-id="{{ $i->id }}">
                                    <span>{{ $i->name }}</span>
                                    <!-- onclick="checkbox_check_ingredient(this)" -->
                                </label>
                            </div>
                        @endforeach
                        @foreach($marks as $key => $value)
                                <div>
                                    <label>
                                        <input type="checkbox" name="marks[]" value="{{ $key }}" autocomplete="off"
                                               data-filter="mark"
                                               data-id="{{ $key }}">
                                        <span>{{ $value['title'] }}</span>
                                        <!-- onclick="checkbox_check_mark(this)" -->
                                    </label>
                                </div>
                        @endforeach
	                </div>

                    @if($category->is_pizza)
                        <style>
                            .pizza-later {
                                display: block;
                                width: 100%;
                                color: #faf655;
                                font-size: 17pt;
                                font-family: "Roboto", sans-serif;
                                border-top: 1px dashed #ff9c00;
                                border-bottom: 1px dashed #ff9c00;
                                padding: 5px 0px;
                            }
                        </style>
                        <div class="pizza-later">
                            Заказы по пицце принимаются только по Днепру.
                            Для жителей Запорожья пицца будет доступна с 01.11.2016
                        </div>
                    @endif
                    <div class="clr"></div>

	                <div class="product-list clearfix" id="products">

						@if($category->is_pizza)
                            <div class="pizza-constructor">
                                <img src="{{ asset('/uploads/pizza/basket.png') }}" alt="" width="380" height="335"
                                     onclick="window.location = '{{ action('Site\PizzaController@index') }}'" style="cursor: pointer;">
                                <div>
                                    <div class="name" onclick="window.location = '{{ action('Site\PizzaController@index') }}'" style="cursor: pointer;">
                                        Конструктор пиццы
                                    </div>
                                    <div class="link" >
                                        <a href="{{ action('Site\PizzaController@index') }}">Перейти</a>
                                    </div>
                                </div>
                            </div>
                        @endif
					
	                    @foreach($products as $product)
							@include('site.partials.product')
	                    @endforeach
						
	                </div>

                @else
                    <div class="category-title">
                        <span class="title">{{ str_replace('<br>', ' ', $category->name) }}</span>
                    </div>
                @endif
	        </form>
        </div>
    </section>

    <section id="bottom">
        <div class="wrap clearfix">
            <div class="bnr">
                <img src="{{ asset('uploads/categories/'.$category->image) }}" alt="">
            </div>
            <div class="seo-text">
					<?php echo $category->text; ?>
            </div>
        </div>
    </section>

@stop