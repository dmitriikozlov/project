@extends('site.layout.index')

@section('meta')
	<?php 
		$meta = null;
		if($product->meta_id != null)
			$meta = \App\Models\Meta::find($product->meta_id);
	?>
	@if($meta != null)
		<title>{{ $meta->title != null ? $meta->title : '' }}</title>
		<meta name="description" content="{{ $meta->title != null ? $meta->description : '' }}" >
		<meta name="keywords" content="{{ $meta->title != null ? $meta->keywords : '' }}" >
		<meta name="robots" content="{{ $meta->title != null ? $meta->robots : '' }}" >
	@endif
@stop

@section('content')

    <div class="bg-black">

        <nav id="breadcrumbs">
            <div class="wrap">
                <a href="{{ url('/') }}">Главная</a>
                <span class="separator"></span>
                <a href="{{ url('catalog/'.$product->catUrl) }}">
                    {{ str_replace('<br>', ' ', $product->catName) }}</a>
                <span class="separator"></span>
                <span>{{ $product->name }}</span>
            </div>
        </nav>

        <section id="product">
            <div class="wrap clearfix">

                <div class="sbtns">
                    <a onclick="ga('send', 'event', 'HOME', 'INSTAGRAMM'); yaCounter37864800.reachGoal('INSTAGRAMM');" href="https://instagram.com/rnr.com.ua" rel="nofollow" target="_blank"><i class="icon-sinst"></i></a>
                    <a onclick="ga('send', 'event', 'HOME', 'VK'); yaCounter37864800.reachGoal('VK');" href="https://vk.com/rnrcomua" rel="nofollow" target="_blank"><i class="icon-svk"></i></a>
                    <a onclick="ga('send', 'event', 'HOME', 'FB'); yaCounter37864800.reachGoal('FB');" href="https://facebook.com/rnrcomua" rel="nofollow" target="_blank"><i class="icon-sfb"></i></a>
                </div>

                <div class="image">
                    <img src="{{ url('uploads/products') . '/' . $product->image }}">
                </div>
                <div class="info">
                    <h1>{{ $product->name }}</h1>
                    @if($product->mark)
                        <div class="mark type_{{ $product->mark }}">
                           <i class="{{ config('marks.'.$product->mark.'.icon') }}"></i> {{ config('marks.'.$product->mark.'.title') }}
                        </div>
                    @endif

                    <div class="consist">
                        <span>Состав: </span>
                        <?php
                        $cons = '';
                        foreach($ingredients as $ingredient){
                            $cons.=  $ingredient.', ';
                        }
                        echo substr($cons,0,-2).'.'; ?>
                    </div>

                    {{--@if($product->is_pizza)--}}
                        {{--<button class="add-button">+ ДОБАВИТЬ ИНГРЕДИЕНТЫ</button>--}}
                    {{--@endif--}}

                    <div class="weight">
                        <span>Вес: </span> {{ round($product->weight) }} г
                    </div>

					<!--
                    <div class="calories">
                        <span>Калорийность блюда: </span> $product->calory ккал.
                    </div>
					-->

                    <div class="buy-block clearfix">
                        <div class="price">
                            {{ round($product->price) }}.<sup>{{ substr(sprintf("%.2f", $product->price - round($product->price)), 2) }}</sup>
                        </div>
                        <div class="buy" data-id="product-order">
							<input data-id="product-id" type="hidden" value="{{ $product->id }}">
                            <button class="type_{{ $product->mark }}">В ТАРЕЛКУ</button>
                        </div>
                    </div>

                    <div class="delivery">
                        <div class="free">
                            <div><span>Бесплатная</span>доставка</div>
                            <i class="icon-shipping"></i>
                        </div>
                        <div class="schedule">Заказы принимаем с 10:00 до 22:00</div>
                    </div>

                </div>

            </div>
        </section>

    </div>

	@if($products->count() > 0)
    <section id="related_products">
        <div class="wrap">
			<style>
                .page-title{
                    position: relative;
                    margin-bottom: 30px;
                    line-height: 1;
                    color: #faf655;
                    font-size: 26px;
                    text-transform: uppercase;

            </style>
			<div class="page-title text-center">ИДЕАЛЬНОЕ ДОПОЛНЕНИЕ</div>
			<!--
            <div class="dotted-title">
                <i class="before"></i>
                <span></span>
                <i class="after"></i>
            </div>
			-->

            <div class="offer-addition product-list clearfix">
                <?php $productMarks = config('marks') ?>
                @foreach($products as $product)
					@include('site.partials.product')
                @endforeach
            </div>
        </div>
    </section>
	@endif
	
	@if(strlen($product->recipe) > 0)
    <section id="recipe">
        <div class="wrap">
            <h2>ПОШАГОВЫЙ РЕЦЕПТ ПРИГОТОВЛЕНИЯ</h2>
            <div>
                {!! $product->recipe !!}
            </div>
        </div>
    </section>
	@endif

@stop