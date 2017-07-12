@foreach($products as $product)
    <a href="{{ url('product') . '/' . $product->id }}">{{ $product->name }}</a>
@endforeach