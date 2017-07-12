@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца: Категории</h1>
        <form action="{{ $category ? action('Admin\PizzaCategoryController@update', ['id' => $category->id])
                                   : action('Admin\PizzaCategoryController@store') }}"
              method="post">
            {{ csrf_field() }}
            {{ method_field($category ? 'put' : 'post') }}
            <div class="row">
                <label>Название</label>
                <input name="name" type="text" value="{{ $category ? $category->name : '' }}" required>
            </div>
            <div style="height: 5px;"></div>
            <div class="row">
                <label>Ингредиенты</label>
                @if($category)
                    <a class="btn btn-success" href="{{ action('Admin\PizzaIngredientController@index', ['id' => $category->id]) }}">
                        Ингредиенты
                    </a>
                @else
                    <span>Ингредиенты можно добавлять в режиме редактирования (кнопка "изменить")</span>
                @endif
            </div>
            <div class="row">
                <label>Показывать?</label>
                <input name="published" type="checkbox" {{ $category ? ($category->published ? 'checked' : '') : 'checked' }}>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    {{ $category ? 'Изменить' : 'Сохранить' }}
                </button>
            </div>
        </form>
    </div>
@stop