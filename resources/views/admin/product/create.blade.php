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
        <form action="{{ url('/admin/product/create/') }}"
              method="post"
              enctype="multipart/form-data">
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<table class="table table-hover">
				<tr>
					<td>Название</td>
					<td>
						<input class="form-control" name="name" type="text" required>
					</td>
				</tr>
				<tr>
					<td>Тип товара</td>
					<td>
						<select class="form-control" name="type" type="text">
							<option value="sale" selected>Обычный</option>
							<option value="hot">Новинка</option>
							<option value="custom">Другой</option>
						</select>
					</td>
				</tr>
				<tr style="display: none">
					<td>Белки</td>
					<td>
						<input class="form-control" name="protein" type="text" value="0" required >
					</td>
				</tr>
				<tr style="display: none">
					<td>Жири</td>
					<td>
						<input class="form-control" name="fat" type="text" value="0" required >
					</td>
				</tr>
				<tr style="display: none">
					<td>Углеводы</td>
					<td>
						<input class="form-control" name="carbohydrate" type="text" value="0" required >
					</td>
				</tr>
				<tr style="display: none">
					<td>Калории</td>
					<td>
						<input class="form-control" name="calory" type="text" value="0" required>
					</td>
				</tr>
				<tr>
					<td>Вес</td>
					<td>
						<input class="form-control" name="weight" type="text" required >
					</td>
				</tr>
				<tr>
					<td>Кол-во</td>
					<td>
						<input class="form-control" name="amount" type="text" required>
					</td>
				</tr>
				<tr>
					<td>Цена</td>
					<td>
						<input class="form-control" name="price" type="text" required > 
					</td>
				</tr>
				<tr style="display: none">
					<td>Джоули</td>
					<td>
						<input class="form-control" name="joule" type="text" value="0" required >
					</td>
				</tr>
				<tr>
					<td>Рецепт</td>
					<td>
						<textarea class="form-control editor" name="recipe"></textarea>
					</td>
				</tr>
				<tr>
					<td>Изображение</td>
					<td>
						<img id="image_file" src="" alt="" width="200" height="200">
                        <input id="input_file" name="image" type="file">
                        <button type="button" id="input_button" class="btn btn-success">Загрузить</button>
                    </td>
				</tr>
				<tr>
					<td>Марка</td>
					<td>
						<select name="mark" class="form-control">
						@for($i = 0; $i < count(config('marks')); $i++)
							<option value="{{ $i }}">{{ config('marks')[$i]['title'] }}</option>
						@endfor
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Показывать?
					</td>
					<td>
						<input name="show" type="radio" value="0">Нет
						<input name="show" type="radio" value="1" checked>Да
					</td>
				</tr>
				<tr>
					<td>
						Категория
					</td>
					<td>
						<select name="category">
							<option value="-1">Не задавать</option>
							@foreach(\App\Models\Category::all() as $c)
								<option value="{{ $c->id }}">{{ $c->name }}</option>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<input class="btn btn-success" id="button_product_products" type="button"
						onclick="button_product_products() }}')"
						value="Добавить сопутствующий товар">
					</td>
					<td>
						<div id="container_product">
						
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<input class="btn btn-success" id="button_product_ingredients" name="button_product_ingredients" type="button"
						onclick="button_product_ingredients() }}')"
						value="Добавить ингредиент">
					</td>
					<td>
						<div id="container_ingredient">
						
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
							   value="1">
					</td>
				</tr>
				<tr>
					<td>
						Title
					</td>
					<td>
						<input name="meta_title" type="text">
					</td>
				</tr>
				<tr>
					<td>
						Description
					</td>
					<td>
						<textarea class="textarea" name="meta_description"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Keywords
					</td>
					<td>
						<textarea class="textarea" name="meta_keywords"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Robots
					</td>
					<td>
						<select name="meta_robots">
							<option value="index,follow">index,follow</option>
							<option value="noindex,follow">noindex,follow</option>
							<option value="index,nofollow">index,nofollow</option>
							<option value="noindex,nofollow">noindex,nofollow</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<input class="btn btn-primary" type="submit" value="Создать">
					</td>
				</tr>
				
			</table>
        </form>
    </div>
@endsection