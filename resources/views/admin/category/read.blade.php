@extends('admin.layout.index')

@section('content')
	<div class="container"> <table class="table table-hover">
				<tr>
					<th>Код</th>
					<th>Название</th>
					<th>Класс</th>
					<th>Изображение</th>
					<th></th>
				</tr>
				
					<tr>
						<td>{{ $category->id }}</td>
						<td>{{ $category->name }}</td>
						<td>{{ $category->class }}</td>
						<td><img src="{{ URL::to('/uploads/categories/') . '/' .$category->image }}"></td>
						<td>
							<a class="btn btn-primary" href="{{ URL::to('/admin/category/read/') . '/' . $category->id }}">Показать</a>
							<a class="btn btn-success" href="{{ URL::to('/admin/category/update/') . '/' . $category->id }}">Изменить</a>
							<a class="btn btn-danger" href="{{ URL::to('/admin/category/delete/') . '/' . $category->id }}">Удалить</a>
						</td>
					</tr>
					<tr>
						<th colspan="5">Текст</td>
					</tr>
					<tr>
						<td>
							{{ $category->text }}
						</td>
					<tr>
					<tr>
						<th colspan="6">Продукты</th>
					</tr>
						@foreach($category_products as $category_product)
							@foreach($products as $product)
								@if($category->id == $category_product->category_id
								&& $category_product->product_id == $product->id)
									<tr>
										<td>{{ $product->id }}</td>
										<td>{{ $product->name }}</td>
									</tr>
								@endif
							@endforeach
						@endforeach
					<tr style="height:100px;"></tr>
				
			</table>
    </div>
@endsection