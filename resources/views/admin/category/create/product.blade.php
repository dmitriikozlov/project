<select class="form-control" name="product[]">
	<option value="-1">Пусто</option>
    @foreach($products as $product)
		@if($product->type != 'custom')
			<option value="{{ $product->id }}">
				{{ $product->id }} | {{ $product->name }}
			</option>
		@endif
    @endforeach
</select>
<br>