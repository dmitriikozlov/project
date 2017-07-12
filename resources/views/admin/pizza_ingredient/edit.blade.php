@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца: Категории: Ингредиенты</h1>
        <form action="{{ $ingredient ? action('Admin\PizzaIngredientController@update', ['id' => $id, 'id2' => $ingredient->id])
                                     : action('Admin\PizzaIngredientController@store', ['id' => $id]) }}"
              method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <label>Название</label>
                <input name="name"
                       type="text"
                       value="{{ $ingredient ? $ingredient->name : '' }}"
                       required>
            </div>
            <div class="row">
                <label>Изображение</label>
                <input name="image"
                       type="file">
            </div>
            <div class="row">
                <label>Вес</label>
                <input name="weight"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ $ingredient ? $ingredient->weight : '' }}"
                       required>
            </div>
            <div class="row">
                <label>Цена</label>
                <input name="price"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ $ingredient ? $ingredient->price : '' }}"
                       required>
            </div>
            <div class="row">
                <label>Показывать?</label>
                <input name="published" type="checkbox" {{ $ingredient ? ($ingredient->published ? 'checked' : '') : 'checked' }}>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    {{ $ingredient ? 'Изменить' : 'Создать' }}
                </button>
            </div>
        </form>
    </div>
@stop