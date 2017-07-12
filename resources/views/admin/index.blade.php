@extends('admin.layout.index')

@section('content')
	<div class="container">
		<div>Пользователи</div>
                <a class="btn btn-success" href="{{ route('admin.register') }}">Зарегистрировать пользователя</a>
		<table class="table table-hover">
			<tr>
				<td>Код</td>
				<td>Имя</td>
				<td>Email</td>
                                <td></td>
			</tr>
			@foreach(\App\User::all() as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('admin.edit', ['id' => $user->id]) }}">Изменить</a>
                                    <form style="display: inline-block;" action="{{ route('admin.delete', ['id' => $user->id]) }}" method="post">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger" type="submit">Удалить</button>
                                    </form>
                                </td>
                            </tr>
			@endforeach
		</table>
	</div>
@endsection