@extends('admin.layout.index')

@section('content')
    <section>
        <a href="{{ \URL::to('/admin/size/create/') }}">Добавить размер</a>
        <br>
        <table>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Вес</th>
                <th>Цена</th>
            </tr>
            @foreach($sizes as $size)
                <tr>
                    <td>{{ $size->id }}</td>
                    <td>{{ $size->name }}</td>
                    <td>{{ $size->weight }}</td>
                    <td>{{ $size->price }}</td>
                    <td>
                        <a href="{{ URL::to('/admin/size/read/') . '/' . $size->id }}">Показать</a>
                        <a href="{{ URL::to('/admin/size/update/') . '/' . $size->id }}">Изменить</a>
                        <a href="{{ URL::to('/admin/size/delete/') . '/' . $size->id }}">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
@endsection