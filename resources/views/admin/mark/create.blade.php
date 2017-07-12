@extends('admin.layout.index')

@section('content')
    <form action="{{ url('/admin/mark/create/') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table style="border: 1px solid black; border-collapse: collapse;">
            <tr>
                <td>Название</td>
                <td><input name="name" type="text"></td>
            </tr>
            <tr>
                <td>Изображение</td>
                <td><input name="image" type="file"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input name="submit" type="submit" value="Создать">
                </td>
            </tr>
        </table>
    </form>
@stop