@extends('admin.layout.index')

@section('content')
	<div class="container">
		<h2>Meta</h2>
		<form id="form" action="{{ $is_new ? route('admin.meta.store') : route('admin.meta.update', ['id' => $meta->id]) }}" method="post">
			{{ csrf_field() }}
			{{ $is_new ? '' : method_field("put") }}
			<table class="table table-hover">
				<tr>
					<td>URL</td>
					<td>
						<input type="text" name="url" value="{{ $is_new ? "" : $meta->url }}">
					</td>
				</tr>
				<tr>
					<td>Published?</td>
					<td>
						<input type="checkbox" name="published" value="1" {{ $is_new ? "checked" : ($meta->published ? "checked" : "") }}>
					</td>
				</tr>
				<tr>
					<td>Title</td>
					<td>
						<input type="text" name="title" value="{{ $is_new ? "" : $meta->title }}">
					</td>
				</tr>
				<tr>
					<td>Description</td>
					<td>
						<input type="text" name="description" value="{{ $is_new ? "" : $meta->description }}">
					</td>
				</tr>
				<tr>
					<td>Keywords</td>
					<td>
						<input type="text" name="keywords" value="{{ $is_new ? "" : $meta->keywords }}">
					</td>
				</tr>
				<tr>
					<td>Robots</td>
					<td>
						<table>
							<tr>
								<td>Index:</td>
								<td>
									<input type="radio" name="robots_index" value="no" checked> No 
									<input type="radio" name="robots_index" value="yes"> Yes
									<input type="radio" name="robots_index" value="skip"> Skip
								</td>
							</tr>
							<tr>
								<td>Follow:</td>
								<td>
									<input type="radio" name="robots_follow" value="no" checked> No 
									<input type="radio" name="robots_follow" value="yes"> Yes
									<input type="radio" name="robots_follow" value="skip"> Skip
								</td>
							</tr>
							<tr>
								<td>Snippet:</td>
								<td>
									<input type="radio" name="robots_snippet" value="no" checked> No 
									<input type="radio" name="robots_snippet" value="yes"> Yes
									<input type="radio" name="robots_snippet" value="skip"> Skip
								</td>
							</tr>
							<tr>
								<td>Archive:</td>
								<td>
									<input type="radio" name="robots_archive" value="no" checked> No 
									<input type="radio" name="robots_archive" value="yes"> Yes
									<input type="radio" name="robots_archive" value="skip"> Skip
								</td>
							</tr>
							<tr>
								<td>Odp:</td>
								<td>
									<input type="radio" name="robots_odp" value="no" checked> No 
									<input type="radio" name="robots_odp" value="yes"> Yes
									<input type="radio" name="robots_odp" value="skip"> Skip
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<a href="#" onclick="document.getElementById('form').submit()">Save</a>
						<a href="{{ route('admin.meta.index') }}">Cancel</a>
					</td>
				</tr>
			</table>
		</form>
	</div>
@stop