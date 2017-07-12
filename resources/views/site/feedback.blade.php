@extends('site.layout.index')

@section('content')
    @if($method == "get")
        <form action='{{ url()->current() }}' method="post" style='color: white'>
            {{ csrf_field() }}
            Как к Вам обращаться:
            <input type="text" name="name" required placeholder="фамилия имя отчество" x-autocompletetype="name"><br>
            Email для связи:
            <input type="email" name="email" required placeholder="адрес электронной почты" x-autocompletetype="email"><br>
            Ваше сообщение:
            <textarea name="message" required rows="5"></textarea><br>
            <input type="submit" value="отправить">
        </form>
    @endif
    @if($method == "post")
        <span style="color: white">
            Спасибо за ваш отзыв
        </span>
    @endif
@stop