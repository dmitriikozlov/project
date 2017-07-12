@extends('admin.layout.index')

@section('content')
    <form action="{{ route("admin.page.update", ['id' => $page->id]) }}"  enctype="multipart/form-data"
          method="post">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="wrap-center">
            <table class="table table-hover">
                <tr>
                    <td>Название</td>
                    <td>
                        <input class="form-control" name='title' type='text' value="{{ $page->title }}" required>
                    </td>
                </tr>
                <tr>
                    <td>Адресс</td>
                    <td>
                        <input class="form-control" name='url' type='text' value="{{ $page->url }}" required>
                    </td>
                </tr>
                <tr valign="top">
                    <td>Контент</td>
                    <td>
                        <textarea name='content' class="form-control editor">{!! $page->content !!}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>Изображение</td>
                    <td>
                        <input id="input_file" name="image" type="file">
                        @if($page->image)
                            <div>
                                <div>
                                    <img src="{{ asset('uploads/pages/'.$page->image) }}" alt="">
                                </div>
                                <label><input type="checkbox" name="delete_image" value="1"> Удалить</label>
                            </div>
                        @endif
                    </td>
                </tr>
				
				<?php 
					$meta = null;
					if($page->meta_id != null)
						$meta = \App\Models\Meta::find($page->meta_id);
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
                        <input class="btn btn-primary" name='submit' type="submit" value='Изменить'>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </form>
@stop