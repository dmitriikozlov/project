<div class="product clearfix">
    <input data-id="pizza-id-value" type="hidden" name="pizza[{{ $pizza->id }}][id]" value="{{ $pizza->id }}">
    <input data-id="pizza-order-id-value" type="hidden" name="pizza[{{ $pizza->id }}][order_id]" value="{{ $pizza->order_id }}">
    <input data-id="pizza-count-value" type="hidden" name="pizza[{{ $pizza->id }}][count]" value="{{ $pizza->count }}">
    <input data-id="pizza-price-value" type="hidden" name="pizza[{{ $pizza->id }}][price]" value="{{ $pizza->price }}">
    <div class="image" style="background-image:url('{{ asset('uploads/pizza/basket.png') }}');"></div>
    <div class="name">
        <p>Ваша пицца</p>
        <div class="consist">
            @foreach($pizza->ingredients as $pi)
                @if($pi->count > 0)
                    {{ $pi->name }} {{ $pi->weight * $pi->count }}г,
                @endif
            @endforeach
        </div>
    </div>

    <div class="remove">
        <a data-id="pizza-remove" href="javascript:void(0)"></a>
    </div>
    <div class="qty">
        <div>
            <button data-id="pizza-minus" type="button" class="minus" data-minus="minus">-</button>
            <input data-id="pizza-count" readonly="readonly" type="text" value="{{ $pizza->count }}">
            <button data-id="pizza-plus" type="button" class="plus" data-plus="plus">+</button>
        </div>
    </div>
    <div class="price"><span><span data-id="pizza-price-left">{{ \App\Modules\Price::getPrice($pizza->price * $pizza->count)->left }}</span>.<sup data-id="pizza-price-right">{{ \App\Modules\Price::getPrice($pizza->price * $pizza->count)->right }}</sup></span></div>
</div>