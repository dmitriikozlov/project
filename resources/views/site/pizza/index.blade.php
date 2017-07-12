@extends('site.layout.index')

@section('content')
    <div class="background">
        <div class="pizza">
            <div class="logo">
                <img src="{{ asset('uploads/pizza/pizza-logo.png') }}">
            </div>
            <div class="content">
                <div class="top">
                    <div class="title">
                        <span>конструктор пиццы</span><span>:</span>
                    </div>
                    <div class="size">
                        <div class="select">
                            <div class="selected">
                                <span>размер&nbsp;&nbsp;основы:&nbsp;&nbsp;&nbsp;</span>
                                <span class="white" data-size="size">{{ $pizza_sizes[0]->dimension }}</span>
                                <span class="white white2">см&nbsp;&nbsp;&nbsp;</span>
                                <div class="arrow bottom" data-state="0"></div>
                                <input type="hidden" data-type="size" value="{{ $pizza_sizes[0]->id }}">
                            </div>
                            <div class="context">
                                @foreach($pizza_sizes as $ps)
                                <div>
                                    <span>{{ $ps->dimension }}</span>
                                    <input type="hidden" data-price="price" value="{{ $ps->price }}">
                                    <input type="hidden" data-weight="weight" value="{{ $ps->weight }}">
                                    <input type="hidden" data-type="sizes" value="{{ $ps->id }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="ingredients">
                        <span>Состав: </span>
                        @if($pizza->ingredients)
                            {{ $pizza->ingredients }}
                        @endif
                    </div>
                    <div class="weight">
                        <span>Вес: </span>
                        <span class="value" data-type="weight">{{ $pizza_sizes[0]->weight }}</span>
                        <span>г</span>
                    </div>
                    <div class="price">
                        <span class="left">{{ $pizza_sizes[0]->price_left }}</span><span class="dot">.</span><span class="right">{{ $pizza_sizes[0]->price_right }}</span>
                        <input type="hidden" value="{{ $pizza_sizes[0]->price }}">
                    </div>
                    <div class="order">
                        <input type="hidden" name="token" value="{{ csrf_token() }}">
                        <button id="order_pizza" type="submit">
                            В тарелку!
                        </button>
                    </div>
                </div>
                <div class="menu">
                    @foreach($pizza_categories as $category)
                        <div class="category">
                            <div class="title">
                                <div class="dropdown" data-state="0"></div>
                                <span class="text">{{ $category->name }}</span>
                            </div>
                            <?php $first = true; ?>
                            @foreach($pizza_ingredients as $ingredient)
                                @if($category->id == $ingredient->pizza_category_id)
                                    <div class="ingredients">
                                        @if($first)
                                            <?php
                                            $first = false;
                                            ?>
                                        @else
                                            <div class="item-separator"></div>
                                        @endif
                                        <div class="item">
                                            <input data-type="id" type="hidden" value="{{ $ingredient->id }}">
                                            <div class="image" style="background-image: url('{{ asset('uploads/pizza/ingredients/' . $ingredient->image) }}')"></div>
                                            <div class="name">
                                                <span title="{{ $ingredient->name_full }}">{{ $ingredient->name_short }}</span>
                                                <span class="weight">{{ $ingredient->weight }}</span><span>г</span>
                                            </div>
                                            <div class="price">
                                                <span class="left">{{ $ingredient->price_left }}</span>.<span class="right">{{ $ingredient->price_right }}</span>
                                            </div>
                                            <div class="action">
                                                <div class="minus">
                                                    <span>-</span>
                                                </div>
                                                <div class="count">
                                                    <span data-type="count">0</span>
                                                </div>
                                                <div class="plus">
                                                    <span>+</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @if($pizza->recipe_published)
    <div class="pizza-block">
        <div class="pizza-wrapper">
            <h1>Пошаговый рецепт приготовления</h1>
            <div class="pizza-content">
                <p>{!! $pizza->recipe !!}</p>
            </div>
        </div>
    </div>
    @endif
@stop