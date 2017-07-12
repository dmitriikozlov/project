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
        <table class="table table-hover">
                <tr>
					<td>Код</td>
                    <td>{{ $product->id }}</td>
					<td>
						<a class="btn btn-success" href="{{ url("admin/product/update") . '/' . $product->id }}">Изменить</a>
						<a class="btn btn-danger" href="{{ url("admin/product/delete") . '/' . $product->id }}">Удалить</a>
					</td>
				</tr>
				<tr>
					<td>Название</td>
                    <td>{{ $product->name }}</td>
				</tr>
				<tr>
					<td>Конфигурация товара</td>
					<td>
						<table class="table table-hover">
							<tr>
								<td>Тип</td>
								<td>
									@if($product->type == "hot")
										Новинка
									@endif
									@if($product->type == "sale")
										Обычный
									@endif
									@if($product->type == "custom")
										Другое
									@endif
								</td>
							</tr>
							<tr>
								<td>Марка</td>
								<td>{{ config('marks')[$product->mark]['title'] }}</td>
							</tr>
							<tr>
								<td>Пицца?</td>
								<td>{{ $product->is_pizza ? "Да" : "Нет" 	}}</td>
							</tr>
							<tr>
								<td>Цена</td>
								<td>{{ $product->price }}</td>
							</tr>
							<tr>
								<td>Кол-во</td>
								<td>{{ $product->amount }}</td>
							</tr>
							<tr>
								<td>Кол-во просмотров</td>
								<td>{{ $product->visite }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Изображение</td>
					<td>
						<img src="{{ url('/') . '/uploads/products/' . $product->image }}" alt="{{ $product->image }}">
					</td>
				</tr>
				<tr>
					<td>Рекомендуемый товар</td>
					<td>
						<?php 
							$ids = explode(";", $product->interesting);
							array_pop($ids);
							
							$items = \App\Models\Product::whereIn("id", $ids)->get();
						?>
						<table class="table table-hover">
							@foreach($items as $item)
								<tr>
									<td>Код</td>
									<td>{{ $item->id }}</td>
								</tr>
								<tr>
									<td>Название</td>
									<td><a href="{{ url('admin/product/read') . '/' . $item->id }}">{{ $item->name }}</a></td>
								</tr>
								<tr class="small-separator">
									<td></td>
								</tr>
							@endforeach
						</table>
					</td>
				</tr>
				<tr>
					<td>Весовые характеристики</td>
					<td>
						<table class="table table-hover">
							<tr>
								<td>Вес г.</td>
								<td>{{ $product->weight }}</td>
							</tr>
							<tr>
								<td>Протеин</td>
								<td>{{ $product->protein }}</td>
							</tr>
							<tr>
								<td>Жири</td>
								<td>{{ $product->fat }}</td>
							</tr>
							<tr>
								<td>Углеводы</td>
								<td>{{ $product->carbohydrate }}</td>
							</tr>
							<tr>
								<td>Калории</td>
								<td>{{ $product->calory }}</td>
							</tr>
							<tr>
								<td>Джоули</td>
								<td>{{ $product->joule }}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Рецепт</td>
					<td>
						{{ $product->recipe }}
					</td>
				</tr>
				
				<tr>
					<td>Ингредиенты</td>
					<td>
						<?php
							$items = \App\Models\ProductIngredient::where("product_id", $product->id)->get(["ingredient_id"]);
							$ings = \App\Models\Ingredient::whereIn("id", $items)->get();
						?>
						<table class="table table-hover">
							@foreach($ings as $i)
								<tr>
									<td>Код</td>
									<td>{{ $i->id }}</td>
								</tr>
								<tr>
									<td>Название</td>
									<td><a href="{{ url('admin/ingredient/read') . '/' . $i->id }}">{{ $i->name }}</a></td>
								</tr>
								<tr class="small-separator">
									<td></td>
								</tr>
							@endforeach
						</table>
					</td>
				</tr>
				
				<tr class="separator">
				</tr>
        </table>
    </div>
@endsection