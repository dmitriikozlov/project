@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца: Размер</h1>
        <form action="{{ $size ? action('Admin\PizzaSizeController@update', ['pizza_id' => $pizza_id, 'id2' => $size->id])
                                     : action('Admin\PizzaSizeController@store', ['pizza_id' => $pizza_id]) }}"
              method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <label>Вес</label>
                <input name="weight"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ $size ? $size->weight : '0' }}"
                       required>
            </div>
            <div class="row">
                <label>Размер</label>
                <input name="dimension"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ $size ? $size->dimension : '0' }}"
                       required>
            </div>
            <div class="row">
                <label>Цена</label>
                <input name="price"
                       type="number"
                       min="0"
                       step="0.01"
                       value="{{ $size ? $size->price : '0' }}"
                       required>
            </div>
            <div class="row">
                <label>Показывать?</label>
                <input name="published" type="checkbox" {{ $size ? ($size->published ? 'checked' : '') : 'checked' }}>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    {{ $size ? 'Изменить' : 'Создать' }}
                </button>
            </div>
        </form>
    </div>
@stop