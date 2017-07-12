@extends('admin.layout.index')

@section('content')
	<div class="container">
		<h2>Meta</h2>
		<a href="{{ route('admin.meta.create') }}">Create</a>
		<table class="table table-hover">
			<tr>
				<th>ID</th>
				<th>URL</th>
				<th>Title</th>
				<th></th>
			</tr>
			@foreach($metas as $meta)
			<tr>
				<td>{{ $meta->id }}</td>
				<td>{{ $meta->url }}</td>
				<td>{{ $meta->title }}</td>
				<td>
					<a href="{{ route('admin.meta.edit', ['id' => $meta->id]) }}">Edit</a>
					<form action="{{ route('admin.meta.destroy', ['id' => $meta->id]) }}" method="post">
						{{ csrf_field() }}
						{{ method_field('delete') }}
						<a href="#" onclick="this.parentNode.submit()">Delete</a>
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
@stop