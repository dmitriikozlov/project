@extends('site.layout.index')

@section('content')
    <div class="main-recipe">
        @foreach($products as $product)
            <div class="recipe-item">
                <a class="item-link" href="{{ url('/recipe/') . '/' . $product->id }}">
                    <img class="item-image"
                         src="{{ url('/') . '/uploads/products/' . $product->image }}">
                </a>
                <span class="item-name"
                      style="background-color: {{ $product->color }}; color: {{ $product->text_color }}">
                    {{ $product->name }}
                </span>
                <span class="item-content">
                    {{ substr($product->recipe, 0, 30) }}
                </span>
            </div>
        @endforeach
        <div class="recipe-pagination">
            <a class="pagination-button" href="{{ url('/recipes/') . '/' . ($page - 1) }}">&lt;</a>
            <a class="pagination-button" href="{{ url('/recipes/') . '/' . ($page + 1) }}">&gt;</a>
        </div>
    </div>
@stop