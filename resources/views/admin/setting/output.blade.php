@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Настройка</h1>
        <form action="{{ action('Admin\SettingController@input', $setting ?  ['id' => $setting->id] : []) }}"
              method="post">
            {{ csrf_field() }}
            <div class="row">
                <label>Описание</label>
                <input name="title"
                       type="text"
                       maxlength="255"
                       value="{{ $setting ? $setting->title : '' }}"
                       required>
            </div>
            <div class="row">
                <label>Ключь</label>
                <input name="key"
                       type="text"
                       maxlength="255"
                       value="{{ $setting ? $setting->key : '' }}"
                       required>
            </div>
            <div class="row">
                <label>Значение</label>
                <textarea name="value">{{ $setting ? $setting->value : '' }}</textarea>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    {{ $setting ? 'Изменить' : 'Создать' }}
                </button>
            </div>
        </form>
    </div>
@stop