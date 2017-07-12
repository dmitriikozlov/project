@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Категории пиццы</h1>
        <a class="btn btn-info" href="{{ action('Admin\PizzaCategoryController@create') }}">
            Создать категорию
        </a>
        <div style="height: 5px;"></div>
        <table class="table table-responsive">
            <tr>
                <th>
                    Код
                </th>
                <th>
                    Название
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>
                        {{ $category->id }}
                    </td>
                    <td>
                        {{ $category->name }}
                    </td>
                    <td>
                        <a class="btn btn-success" href="{{ action('Admin\PizzaCategoryController@edit', ['id' => $category->id]) }}">
                            Изменить
                        </a>
                        <form action="{{ action('Admin\PizzaCategoryController@destroy', ['id' => $category->id]) }}"
                              method="post"
                              style="display: inline-block">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger" type="submit">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop