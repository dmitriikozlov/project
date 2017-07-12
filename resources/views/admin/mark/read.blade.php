@extends('admin.layout.index')

@section('content')
    <style>
        table {
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr {
            border: 1px solid black;
        }
        td {
            border: 1px solid black;
            vertical-align: top;
        }
        img {
            width: 40px;
            height: 40px;
        }
    </style>
    <a href="{{ url('/admin/mark/create/') }}">Добавить маркировку</a>
    <table>
        <tr>
            <th>Код</th>
            <th>Название</th>
            <th>Фото</th>
        </tr>
        <tr>
            <td>{{ $mark->id }}</td>
            <td>{{ $mark->name }}</td>
            <td>
                <img src="{{ url('/') . '/uploads/marks/' . $mark->image }}" alt="{{ $mark->image }}">
            </td>
            <td>
                <a href="{{ url('/admin/mark/') }}">Маркировки</a>
                <a href="{{ url('/admin/mark/update/') . '/' . $mark->id }}">Изменить</a>
                <a href="{{ url('/admin/mark/delete/') . '/' . $mark->id }}">Удалить</a>
            </td>
        </tr>
    </table>
@stop