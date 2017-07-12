@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <a class="btn btn-warning" href='{{ url('admin/page/create') }}'>Создать</a>
        <table class="table table-hover">
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Адресс</th>
				<th></th>
            </tr>
            @foreach(\App\Models\Page::all() as $page)
                <tr valign="top">
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->url }}</td>
                    <td style="text-align: right">
                        <a class="btn btn-primary" href="{{ url('admin/page', $page->id) }}">Показать</a>
                        <a class="btn btn-success" href="{{ route('admin.page.edit', ['id' => $page->id]) }}">Редактировать</a>
                        <form action="{{ route('admin.page.destroy', ['id' => $page->id]) }}"
                              method='post'
							  style="display: inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <a class="btn btn-danger" href="#" onclick='this.parentNode.submit();'>Удалить</a>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop