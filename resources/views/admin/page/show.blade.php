@extends('admin.layout.index')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <tr>
                <td>Код</td>
				<td>{{ $page->id }}</td>
				<td style="text-align: right;">
                    <a class="btn btn-primary" href="{{ url('admin/page') }}">Назад</a>
                    <a class="btn btn-success" href="#">Редактировать</a>
                    <a class="btn btn-danger" href="#">Удалить</a>
                </td>
			</tr>
			<tr>
                <td>Название</td>
				<td colspan="2">{{ $page->title }}</td>
			</tr>
			<tr>
                <td>Адресс</td>
				<td colspan="2">{{ $page->url }}</td>
			</tr>
			<tr>
                <td colspan="3">Контент</td>
            </tr>
			<tr>
				<td colspan="3">{!! $page->content !!}</td>
			</tr>
        </table>
    </div>
@stop