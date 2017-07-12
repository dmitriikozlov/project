@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца</h1>
        @if (count($errors) > 0)
            {{ dd($errors) }}
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ action('Admin\PizzaController@save') }}"
              method="post">
            {{ csrf_field() }}
            <div class="row">
                <a class="btn btn-success" href="{{ action('Admin\PizzaCategoryController@index') }}">
                    Категории
                </a>
            </div>
            <div style="height: 5px;"></div>
            <div class="row">
                <a class="btn btn-success" href="{{ action('Admin\PizzaSizeController@index', ['pizza_id' => $pizza->id]) }}">
                    Размеры
                </a>
            </div>
            <div class="row">
                <label>Рецепт</label>
                <textarea name="recipe" class="editor">{{ $pizza->recipe }}</textarea>
            </div>
            <div class="row">
                <label>Показать рецепт?</label>
                <input name="recipe_published"
                       type="hidden"
                       value="0">
                <input name="recipe_published"
                       type="checkbox"
                       value="1"
                       {{ $pizza->recipe_published ? 'checked' : '' }}>
            </div>
            <div class="row">
                <label>Базовые ингредиенты</label>
                <textarea name="ingredients">{{ $pizza->ingredients }}</textarea>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    Изменить
                </button>
            </div>
        </form>
    </div>
@stop