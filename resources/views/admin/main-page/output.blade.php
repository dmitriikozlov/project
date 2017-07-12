@extends('admin.layout.index')

@section('content')
    <script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
    <div class="container">
        <h1>Настройка -> Главная страница</h1>
        <form action="{{ action('Admin\MainPageController@input', ['id' => $meta->id]) }}"
              method="post">
            {{ csrf_field() }}
            <div class="row">
                <label>Описание</label>
                <input name="title"
                       type="text"
                       maxlength="255"
                       value="{{ $meta->title }}"
                       required>
            </div>
            <div class="row">
                <label>Описание</label>
                <textarea name="description">{{ $meta->description }}</textarea>
            </div>
            <div class="row">
                <label>Описание</label>
                <textarea name="keywords">{{ $meta->keywords }}</textarea>
            </div>
            <div class="row">
                <label>Описание</label>
                <select name="robots">
                    <option value="index,follow"     {{ $meta->robots == "index,follow"     ? "selected" : '' }}>index,follow</option>
                    <option value="noindex,follow"   {{ $meta->robots == "noindex,follow"   ? "selected" : '' }}>noindex,follow</option>
                    <option value="index,nofollow"   {{ $meta->robots == "index,nofollow"   ? "selected" : '' }}>index,nofollow</option>
                    <option value="noindex,nofollow" {{ $meta->robots == "noindex,nofollow" ? "selected" : '' }}>noindex,nofollow</option>
                </select>
            </div>
            <div class="row">
                <button class="btn btn-primary" type="submit">
                    Изменить
                </button>
            </div>
        </form>
    </div>
@stop