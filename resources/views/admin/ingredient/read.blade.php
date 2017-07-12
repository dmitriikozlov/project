@extends('admin.layout.index')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Вес</th>
                <th>Цена</th>
                <th>Ингредиент пиццы?</th>
                <th>Изображение</th>
                <th></th>
            </tr>
            <tr>
                <td>{{ $ingredient->id }}</td>
                <td>{{ $ingredient->name }}</td>
                <td>{{ $ingredient->weight }}</td>
                <td>{{ $ingredient->price }}</td>
                <td>{{ $ingredient->ispizza ? "Да" : "Нет" }}</td>
                <td>
                    <img src="{{ URL::to('/') . '/uploads/ingredients/' . $ingredient->image }}" width="150" height="120">
                </td>
                <td>
                    <a class="btn btn-primary" href="{{ URL::to('/admin/ingredient/') }}">Ингредиенты</a>
                    <a class="btn btn-success" href="{{ URL::to('/admin/ingredient/update/') . '/' . $ingredient->id }}">Изменить</a>
                    <a class="btn btn-danger" href="{{ URL::to('/admin/ingredient/delete/') . '/' . $ingredient->id }}">Удалить</a>
                </td>
            </tr>
        </table>
    </div>
@endsection