@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца: Размеры</h1>
        <a class="btn btn-info" href="{{ action('Admin\PizzaSizeController@create', ['pizza_id' => $pizza_id]) }}">
            Создать размер
        </a>
        <div style="height: 5px;"></div>
        <table class="table table-responsive">
            <tr>
                <th>
                    Код
                </th>
                <th>
                    Вес
                </th>
                <th>
                    Размер
                </th>
                <th>
                    Цена
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($sizes as $size)
                <tr>
                    <td>
                        {{ $size->id }}
                    </td>
                    <td>
                        {{ $size->weight }}
                    </td>
                    <td>
                        {{ $size->dimension }}
                    </td>
                    <td>
                        {{ $size->price }}
                    </td>
                    <td>
                        <a class="btn btn-success" href="{{ action('Admin\PizzaSizeController@edit', ['pizza_id' => $pizza_id, 'size_id' => $size->id]) }}">
                            Изменить
                        </a>
                        <form action="{{ action('Admin\PizzaSizeController@destroy', ['pizza_id' => $pizza_id, 'size_id' => $size->id]) }}"
                              method="post"
                              style="display: inline-block">
                            {{ csrf_field() }}
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