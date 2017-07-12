@for($i = 0; $i < count($products) && $i < 4; $i++)
    <div class="product">

        <div class="win-none">
            <p>
                @foreach(\App\Models\ProductMark::all() as $pm)
                    @foreach(\App\Models\Mark::all() as $m)
                        @if($products[$i]->id == $pm->product_id && $pm->mark_id == $m->id)
                            {{ $m->name }}
                        @endif
                    @endforeach
                @endforeach
            </p>
        </div>

        <a href="{{ url('product/') . '/' . $products[$i]->id }}"><img src="{{ url('/') .'/uploads/products/' . $products[$i]->image }}"></a>
        <div class="quantity">
            <p>Вес:<span> {{ $products[$i]->weight }} г</span></p>
            <p>Количество:<span> {{ $products[$i]->amount }} шт.</span></p>
        </div>
        <div class="price">
            <p>{{ $products[$i]->name }}<span class="cost">{{ round($products[$i]->price) }}.<i>{{ substr(sprintf("%.2f", $products[$i]->price - round($products[$i]->price)), 2) }}</i></span></p>
        </div>
        <div class="consist">
            <p><span>Состав:</span>
                @foreach($products[$i]->getIngredients() as $ing)
                    {{ $ing->name }},
                @endforeach
            </p>
        </div>
        <div class="but-bottom1" onclick="order_click('{{ URL::to('/service/order/') }}', {{ $products[$i]->id }})">
            <img src="{{ url('images/prod-bottom1.png') }}">
            <p>В тарелку</p>
        </div>
    </div>
@endfor