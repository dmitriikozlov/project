@extends('admin.layout.index')

@section('content')
	<style>
        #input_file {
            display: none;
        }
    </style>
	<script>
		product_ingredient_url = '{{ url('admin/product/create/ingredient') }}';
		product_products_url = '{{ url('admin/product/create/product') }}';
		
		window.addEventListener('load', function() {
			document.getElementById("button_product_ingredients").addEventListener('click', function() {
				var ajax = new XMLHttpRequest(); 
				ajax.onreadystatechange = function()
				{
					if(ajax.readyState == 4 && ajax.status == 200)
					{
						var div = document.createElement('div');
						div.innerHTML = ajax.responseText;
						var container = document.getElementById('container_ingredient');
						container.appendChild(div);
					}
				}
				ajax.open('get', product_ingredient_url, true);
				ajax.send();
			});
			
			document.getElementById("button_product_products").addEventListener('click', function() {
				var ajax = new XMLHttpRequest(); 
				ajax.onreadystatechange = function()
				{
					if(ajax.readyState == 4 && ajax.status == 200)
					{
						var div = document.createElement('div');
						div.innerHTML = ajax.responseText;
						var container = document.getElementById('container_product');
						container.appendChild(div);
					}
				}
				ajax.open('get', product_products_url, true);
				ajax.send();
			});
			
			document.getElementById("input_button").addEventListener("click", function() {
                document.getElementById("input_file").click();
            });
			
			document.getElementById("input_file").addEventListener("change", function() {
				  var selectedFile = event.target.files[0];
				  var reader = new FileReader();

				  var imgtag = document.getElementById("image_file");
				  imgtag.title = selectedFile.name;

				  reader.onload = function(event) {
					imgtag.src = event.target.result;
				  };

				  reader.readAsDataURL(selectedFile);
			});
		});
		
		function deleteItem(e) {
				var child = e.parentNode;
				var parent = child.parentNode;
				parent.removeChild(child);
			}
	</script>

	<div class="container">
        <form action="{{ url('/admin/product/update/') }}"
              method="post"
              enctype="multipart/form-data">
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<input name="id" type="hidden" value="{{ $product->id }}">
			<table class="table table-hover">
				<tr>
					<td>Название</td>
					<td>
						<input class="form-control" name="name" type="text" value="{{ $product->name }}" required>
					</td>
				</tr>
				<tr>
					<td>Тип товара</td>
					<td>
						<select class="form-control" name="type" type="text">
							<option value="sale" <?php echo $product->type == "sale" ? "selected" : "" ?>>Обычный</option>
							<option value="hot" <?php echo $product->type == "hot" ? "selected" : "" ?>>Новинка</option>
							<option value="custom" <?php echo $product->type == "custom" ? "selected" : "" ?>>Другой</option>
						</select>
					</td>
				</tr>
				<tr style="display: none">
					<td>Белки</td>
					<td>
						<input class="form-control" name="protein" type="text" required value="{{ $product->protein }}">
					</td>
				</tr>
				<tr style="display: none">
					<td>Жири</td>
					<td>
						<input class="form-control" name="fat" type="text" required value="{{ $product->fat }}">
					</td>
				</tr>
				<tr style="display: none">
					<td>Углеводы</td>
					<td>
						<input class="form-control" name="carbohydrate" type="text" required value="{{ $product->carbohydrate }}">
					</td>
				</tr>
				<tr style="display: none">
					<td>Калории</td>
					<td>
						<input class="form-control" name="calory" type="text" required value="{{ $product->calory }}">
					</td>
				</tr>
				<tr>
					<td>Вес</td>
					<td>
						<input class="form-control" name="weight" type="text" required value="{{ $product->weight }}">
					</td>
				</tr>
				<tr>
					<td>Кол-во</td>
					<td>
						<input class="form-control" name="amount" type="text" required value="{{ $product->amount }}">
					</td>
				</tr>
				<tr>
					<td>Цена</td>
					<td>
						<input class="form-control" name="price" type="text" required value="{{ $product->price }}"> 
					</td>
				</tr>
				<tr style="display: none;">
					<td>Джоули</td>
					<td>
						<input class="form-control" name="joule" type="text" required value="{{ $product->joule }}">
					</td>
				</tr>
				<tr>
					<td>Рецепт</td>
					<td>
						<textarea class="form-control editor" name="recipe">{{ $product->recipe }}</textarea>
					</td>
				</tr>
				<tr>
					<td>Изображение</td>
					<td>
						<img id="image_file" src="{{ url('/') . '/uploads/products/thumb_' . $product->image }}" alt="">
                        <input id="input_file" name="image" type="file">
                        <button type="button" id="input_button" class="btn btn-success">Загрузить</button>
                    </td>
				</tr>
				<tr>
					<td>Марка</td>
					<td>
						<select name="mark" class="form-control">
						@for($i = 0; $i < count(config('marks')); $i++)
							<option value="{{ $i }}" {{ $product->mark == $i ? "selected" : "" }}>{{ config('marks')[$i]['title'] }}</option>
						@endfor
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Показывать?
					</td>
					<td>
						<input name="show" type="radio" value="0" {{ $product->show == 0 ? "checked" : "" }}>Нет
						<input name="show" type="radio" value="1" {{ $product->show == 1 ? "checked" : "" }}>Да
					</td>
				</tr>
				<tr>
					<td>
						Категория
					</td>
					<td>
						<div>
							<select class="form-control" name="category">
								@if($category == null)
									<option value="-1" selected>Пусто</option>
								@else
									<option value="-1">Пусто</option>
									<option value="{{ $category->id }}" selected>{{ $category->name }}</option>
								@endif
								@foreach($categories as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
							<br>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input class="btn btn-success" id="button_product_products" type="button"
						value="Добавить сопутствующий товар">
					</td>
					<td>
						<div id="container_product">
							@foreach($interestings as $interesting)
								<select class="form-control" name="interesting[]" style="display: inline-block; width: 93%;">
									<option value="-1">Пусто</option>
									<option value="{{ $interesting->id }}" selected>{{ $interesting->name }}</option>
									@foreach($products as $product)
										@if($product->id != $interesting->id)
											<option value="{{ $product->id }}">{{ $product->name }}</option>
										@endif
									@endforeach
								</select>
								<button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
								<br>
							@endforeach
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input class="btn btn-success" id="button_product_ingredients" name="button_product_ingredients" type="button"
						value="Добавить ингредиент">
					</td>
					<td>
						<?php $all_ingredients = \App\Models\Ingredient::all(); ?>
						<div id="container_ingredient">
							@foreach($ingredients as $ingredient)
								<div>
									<select class="form-control" name="ingredient[]"  style="display: inline-block; width: 93%;">
										<option value="-1">Пусто</option>
										<option value="{{ $ingredient->id }}" selected>{{ $ingredient->id }} | {{ $ingredient->name }}</option>
										@foreach($all_ingredients as $ai)
											@if($ingredient->id != $ai->id)
												<option value="{{ $ai->id }}">{{ $ai->id }} | {{ $ai->name }}</option>
											@endif
										@endforeach
									</select>
									<button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
									<br>
								</div>
							@endforeach
						</div>
					</td>
				</tr>
				<tr>
					<td>
						Пицца?
					</td>
					<td>
						<input name="is_pizza"
							   type="hidden"
							   value="0">
						<input name="is_pizza"
							   type="checkbox"
							   value="1"
						       {{ $product->is_pizza ? 'checked' : '' }}>
					</td>
				</tr>
				
				<?php 
					$meta = null;
					if($product->meta_id != null)
						$meta = \App\Models\Meta::find($product->meta_id);
				?>
				<tr>
					<td>
						Title
					</td>
					<td>
						<input name="meta_title" type="text" value="{{ $meta != null ? $meta->title : '' }}">
					</td>
				</tr>
				<tr>
					<td>
						Description
					</td>
					<td>
						<textarea class="textarea" name="meta_description">{{ $meta != null ? $meta->description : '' }}</textarea>
					</td>
				</tr>
				<tr>
					<td>
						Keywords
					</td>
					<td>
						<textarea class="textarea" name="meta_keywords">{{ $meta != null ? $meta->keywords : '' }}</textarea>
					</td>
				</tr>
				<tr>
					<td>
						Robots
					</td>
					<td>
						<select name="meta_robots">
							<option value="index,follow"     {{ $meta != null ? ($meta->robots == 'index,follow' ? 'selected' : '') : '' }}>index,follow</option>
							<option value="noindex,follow"   {{ $meta != null ? ($meta->robots == 'noindex,follow' ? 'selected' : '') : '' }}>noindex,follow</option>
							<option value="index,nofollow"   {{ $meta != null ? ($meta->robots == 'index,nofollow' ? 'selected' : '') : '' }}>index,nofollow</option>
							<option value="noindex,nofollow" {{ $meta != null ? ($meta->robots == 'noindex,nofollow' ? 'selected' : '') : '' }}>noindex,nofollow</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						<input class="btn btn-primary" type="submit" value="Изменить">
					</td>
				</tr>
				
			</table>
        </form>
    </div>
@endsection