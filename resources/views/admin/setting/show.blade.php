@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Настройки</h1>
        <div class="container container-fluid">
            <a href="{{ action('Admin\MainPageController@output') }}"
               class="btn btn-default">
                Главная страница
            </a>
        </div>
        <div class="container container-fluid">
            <a class="btn btn-info" href="{{ action('Admin\SettingController@output') }}">
                Создать
            </a>
        </div>
        <table class="table table-responsive">
            <tr>
                <th>
                    Код
                </th>
                <th>
                    Описание (ключь)
                </th>
                <th>
                    Значение
                </th>
                <th></th>
            </tr>
            @foreach($settings as $setting)
                <tr>
                    <td>
                        {{ $setting->id }}
                    </td>
                    <td>
                        {{ $setting->title }} ({{ $setting->key }})
                    </td>
                    <td>
                        {{ $setting->value }}
                    </td>
                    <td>
                        <a class="btn btn-success"
                           href="{{ action('Admin\SettingController@output', ['id' => $setting->id]) }}">
                            Изменить
                        </a>
                        <form style="display: inline"
                              action="{{ action('Admin\SettingController@delete', ['id' => $setting->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            <button class="btn btn-danger"
                                    type="submit">
                                Удалить
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop