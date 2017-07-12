@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Пицца: Категории: Ингредиенты</h1>
        <a class="btn btn-info" href="{{ action('Admin\PizzaIngredientController@create', ['id' => $id]) }}">
            Создать ингредиента
        </a>
        <div style="height: 5px"></div>
        <table class="table table-responsive">
            <tr>
                <th>
                    Код
                </th>
                <th>
                    Название
                </th>
                <th>
                    Изображение
                </th>
                <th>
                    Действия
                </th>
            </tr>
            @foreach($ingredients as $i)
                <tr>
                    <td>
                        {{ $i->id }}
                    </td>
                    <td>
                        {{ $i->name }}
                    </td>
                    <td>
                        @if($i->image != 'empty')
                            <div style="display: inline-block;
                                        width: 50px;
                                        height: 50px;
                                        background-image: url('{{ url('uploads/pizza/ingredients/' . $i->image) }}');
                                        background-size: 100% 100%;">
                            </div>
                        @else
                            <div style="display: inline-block;
                                    width: 50px;
                                    height: 50px;
                                    background-color: black;">
                            </div>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-success" href="{{ action('Admin\PizzaIngredientController@edit', ['id' => $id, 'id2' => $i->id]) }}">
                            Изменить
                        </a>
                        <form action="{{ action('Admin\PizzaIngredientController@destroy', ['id' => $id, 'id2' => $i->id]) }}"
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