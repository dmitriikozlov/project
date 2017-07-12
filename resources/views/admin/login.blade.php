@extends('admin.layout.index')

@section('content')
    <div style="margin: 0 auto; width: 400px;">
        <form action="{{ url('admin/login') }}"
              method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">

            <input name="email"  class="form-control" type="email" placeholder="Почта">
            <br>
            <input name="password"  class="form-control" type="password" placeholder="Пароль">
            <br>
            <input class="btn btn-primary" type="submit" value="Войти">
        </form>
    </div>
@endsection