<select name="product[]">
    @foreach($products as $product)
        <option value="{{ $product->id }}">
            {{ $product->id }} | {{ $product->name }}
        </option>
    @endforeach
</select>
<br><br>