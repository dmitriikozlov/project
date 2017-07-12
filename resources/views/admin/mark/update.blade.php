@extends('admin.layout.index')

@section('content')
    <form action="{{ url('/admin/mark/create/') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table style="border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td>Код</td>
                <td><input name="id" type="hidden" value="{{ $mark->id }}">{{ $mark->id }}</td>
            </tr>
            <tr>
                <td>Название</td>
                <td><input name="name" type="text" value="{{ $mark->name }}"></td>
            </tr>
            <tr>
                <td>Изображение</td>
                <td><input name="image" type="file"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="submit" type="submit" value="Изменить">
                </td>
            </tr>
        </table>
    </form>
@stop