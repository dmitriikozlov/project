@extends('site.layout.index')

@section('content')
    <div class="main-recipe">
        <div class="recipe-breadcrumbs">
            <a class="recipe-breadcrumbs-text" href="{{ url('/') }}">Главная</a>
            <span class="recipe-breadcrumbs-text" >&gt;</span>
            <a class="recipe-breadcrumbs-text" href="{{ url('recipes') }}">Рецепты</a>
            <span class="recipe-breadcrumbs-text" >&gt;</span>
            <span class="recipe-breadcrumbs-text" >{{ $product->name }}</span>
        </div>
        <div class="recipe-element">
            <img class="element-image"
                 src="{{ url('/') . '/uploads/products/' . $product->image }}">
        </div>
        <div class="element-name"
             style="background-color: {{ $product->color }}; color: {{ $product->text_color }}">
                {{ $product->name }}
        </div>
        <div class="element-content">
            {{ $product->recipe }}
        </div>
    </div>
@stop