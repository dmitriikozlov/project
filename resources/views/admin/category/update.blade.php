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
        <form action="{{ URL::to('/admin/category/update/') }}"
              method="post"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
			<input name="id" type="hidden" value="{{ $category->id }}">
			<table class="table table-hover">
				<tr>
					<td>Название</td>
					<td>
						<input class="form-control" name="name" type="text" value="{{ $category->name }}">
					</td>
				</tr>
				<tr>
					<td>
						Класс
					</td>
					<td>
						<select name="class" class="form-control">
							@foreach(config('class') as $item)
								<option value="{{ $item }}" {{ $item == $category->class ? "selected" : "" }}>{{ $item }}</option>
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<td>
						Показывать?
					</td>
					<td>
						<input name="show" type="radio" value="0" {{ $category->show == 0 ? "checked" : "" }}>Нет
						<input name="show" type="radio" value="1" {{ $category->show == 1 ? "checked" : "" }}>Да
					</td>
				</tr>
				<tr>
					<td>Позиция</td>
					<td>
						<input name="position"  class="form-control" value="{{ $category->position }}">
					</td>
				</tr>
				<tr>
					<td>Изображение</td>
					<td>
						<input id="input_file" name="image" type="file">
                        <button id="input_button" type="button" class="btn btn-success">Загрузить</button>
                        @if($category->image!='')
                            <div>
                                <div>
                                    <img src="{{ asset('uploads/categories/'.$category->image) }}" alt="">
                                </div>
                                <label><input type="checkbox" name="delete_image" value="1"> Удалить</label>
                            </div>
                        @endif
					</td>
				</tr>
				<tr>
					<td>Текст</td>
					<td>
						<textarea class="form-control editor" name="text">{{ $category->text }}</textarea>
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
							@foreach($products as $product)
								<div>
									<select class="form-control" name="product[]" autocomplete="off">
										<option value="-1">Пусто</option>
										<?php $all_products = \App\Models\Product::where('type', '!=', 'custom')->get(); ?>
										<option value="{{ $product->id }}" selected>{{ $product->id }} | {{ $product->name }}</option>
										@foreach($all_products as $ap)
											@if($product->id != $ap->id)
												<option value="{{ $product->id }}">
													{{ $ap->id }} | {{ $ap->name }}
												</option>
											@endif
										@endforeach
									</select>
									<br>
								</div>
							@endforeach
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
							   value="1"
							   {{ $category->is_pizza ? 'checked' : '' }}>
					</td>
				</tr>
				
				<?php 
					$meta = null;
					if($category->meta_id != null)
						$meta = \App\Models\Meta::find($category->meta_id);
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
					<td colspan="2">
						<button class="btn btn-primary" type="submit">
							Изменить
						</button>
					</td>
				</tr>
			</table>
        </form>
    </div>
@endsection