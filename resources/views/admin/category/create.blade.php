@extends('admin.layout.index')

@section('content') 
	<style>
        #input_file {
            display: none;
        }
    </style>
	<script>
		category_product_url = '{{ url('admin/category/create/product') }}';
		
		window.addEventListener('load', function() {
			document.getElementById("button_category_products").addEventListener('click', function() {
				var ajax = new XMLHttpRequest(); 
				ajax.onreadystatechange = function()
				{
					if(ajax.readyState == 4 && ajax.status == 200)
					{
						var result = JSON.parse(ajax.responseText);
						
						var div = document.createElement('div');
						div.innerHTML = result.content;
						var container = document.getElementById('content_product');
						container.appendChild(div);
					}
				}
				ajax.open('get', category_product_url, true);
				ajax.send();
			});
			
			document.getElementById("input_button").addEventListener("click", function() {
                document.getElementById("input_file").click();
            });
		});
	</script>
	
    <div class="container">
        <form action="{{ URL::to('/admin/category/create/') }}"
              method="post"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
			<table class="table table-hover">
				<tr>
					<td>Название</td>
					<td>
						<input class="form-control" name="name" type="text">
					</td>
				</tr>
				<tr>
					<td>Класс</td>
					<td>
						<select name="class" class="form-control">
							@foreach(config('class') as $item)
								<option value="{{ $item }}" selected>{{ $item }}</option>
							@endforeach
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
					<td>Позиция</td>
					<td>
						<select name="position" class="form-control">
							<?php $length = count(\App\Models\Category::all()); ?>
							@for($i = 1; $i <= $length; $i++) 
								<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
					</td>
				</tr>
				<tr style="display: none">
					<td>Изображение</td>
					<td>
						<input id="input_file" name="image" type="file">
                        <button id="input_button" class="btn btn-success">Загрузить</button>
					</td>
				</tr>
				<tr>
					<td>Текст</td>
					<td>
						<textarea class="form-control editor" name="text"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<button id="button_category_products" class="btn btn-success" type="button">
							Добавить продукт
						</button>
					</td>
					<td>
						<div id="content_product">

						</div>
					</td>
				</tr>
				<tr>
					<td>
						Категория пиццы?
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
				
				<?php 
					$meta = null;
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
						<input class="btn btn-primary" type="submit" value="Создать">
					</td>
				</tr>
			</table>
        </form>
    </div>
@endsection