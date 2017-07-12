@extends('admin.layout.index')

@section('content')
    <div style="margin: 0 auto; width: 400px;">
        <form action="{{ route('admin.register') }}"
              method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table class="table">
                <tr>
                    <td>Имя</td>
                    <td>
                        <input name="name"  class="form-control" type="text">
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input name="email"  class="form-control" type="email">
                    </td>
                </tr>
                <tr>
                    <td>Пароль</td>
                    <td>
                        <input name="password"  class="form-control" type="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="btn btn-primary" type="submit" value="Зарегистрировать">
                    </td>
                </tr>
            </table>
        </form>
    </div>
@endsection