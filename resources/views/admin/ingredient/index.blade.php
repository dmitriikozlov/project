@extends('admin.layout.index')

@section('content')
    <div class="container">
        <a class="btn btn-warning" href="{{ \URL::to('/admin/ingredient/create/') }}">Добавить ингредиент</a>
        <br>
        @if(count($ingredients) > 0)
        <table class="table table-hover">
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Вес</th>
                <th>Цена</th>
                <th>Ингредиент пиццы?</th>
                <th></th>
            </tr>
            @foreach($ingredients as $ingredient)
                <tr>
                    <td>{{ $ingredient->id }}</td>
                    <td>{{ $ingredient->name }}</td>
                    <td>{{ $ingredient->weight }}</td>
                    <td>{{ $ingredient->price }}</td>
                    <td>{{ $ingredient->ispizza ? "Да" : "Нет" }}</td>
                    <td>
                        <a class="btn btn-success" href="{{ URL::to('/admin/ingredient/update/') . '/' . $ingredient->id }}">Изменить</a>
                        <a class="btn btn-danger" href="{{ URL::to('/admin/ingredient/delete/') . '/' . $ingredient->id }}">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </table>
        @endif
    </div>
@endsection