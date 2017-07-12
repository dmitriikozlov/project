@extends('admin.layout.index')

@section('content')
	<style>
		table {
			border: 1px solid lightgray;
		}
		.separator {
			height: 200px;
		}
		.small-separator {
			height: 50px;
		}
	</style>
    <div class="container">
        <a class="btn btn-warning" href="{{ \URL::to('/admin/product/create/') }}">Добавить продукт</a>
        <br>
        <table class="table table-hover">
			<tr>
				<th>Код</th>
				<th>Название</th>
				<th>Категория</th>
				<th>Изображение</th>
				<th></th>
			</tr>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
					<td>{{ $product->name }}</td>
					<td>
						@foreach($product->cats as $c)
							{{ str_replace("<br>", ' ', $categories[$c]) }}
						@endforeach
					</td>
					<td>
						<img src="{{ url('/') . '/uploads/products/' . $product->image }}" alt="{{ $product->image }}" width="100" height="80">
					</td>
					<td>
						<a class="btn btn-success" href="{{ url("admin/product/update") . '/' . $product->id }}">Изменить</a>
						<a class="btn btn-danger" href="{{ url("admin/product/delete") . '/' . $product->id }}">Удалить</a>
					</td>
				</tr>
            @endforeach
			{!! $products->links() !!}
        </table>
    </div>
@endsection