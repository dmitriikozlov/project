@extends('admin.layout.index')

@section('content')
    <div class="container">
        <a class="btn btn-warning" href="{{ URL::to('/admin/category/create/') }}">Добавить категорию</a>
        <br>
        <br>
		@if(count($categories) > 0)
			<table class="table table-hover">
				<tr>
					<th width="1%">Код</th>
					<th>Название</th>
					<th width="20%"></th>
				</tr>
				@foreach($categories as $category)
					<tr>
						<td>{{ $category->id }}</td>
						<td>{{ str_replace("<br>", ' ', $category->name) }}</td>
						<td>
							<a class="btn btn-success" href="{{ URL::to('/admin/category/update/') . '/' . $category->id }}">Изменить</a>
							<a class="btn btn-danger" href="{{ URL::to('/admin/category/delete/') . '/' . $category->id }}">Удалить</a>
						</td>
					</tr>
				@endforeach
			</table>
		@endif
    </div>
@endsection