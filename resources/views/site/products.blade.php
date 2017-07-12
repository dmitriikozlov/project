@extends('site.layout.index')

@section('content')

    <div class="wrap-center">
        <div class="offer">
            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Продукты
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>
        </div>
    </div>

    <div class="wrap-center">

        @for($i = 0; $i < count($products); $i++)
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

                <img src="{{ url('uploads/products/') . '/' . $products[$i]->image }}">
                <div class="quantity">
                    <p>Вес:<span> {{ $products[$i]->weight }} г</span></p>
                    <p>Количество:<span> {{ $products[$i]->amount }} шт.</span></p>
                </div>
                <div class="price">
                    <p>{{ $products[$i]->name }}<span class="cost">210.<i>00</i></span></p>
                </div>
                <div class="consist">
                    <p><span>Состав:</span>
                        @foreach($products[$i]->getIngredients() as $ing)
                            {{ $ing->name }},
                        @endforeach
                    </p>
                </div>
                <div class="but-bottom" onclick="order_click('{{ URL::to('/service/order/') }}', {{ $products[$i]->id }})">
                    <img src="{{ url('images/prod-bottom1.png') }}">
                    <p>В тарелку</p>
                </div>
            </div>
        @endfor
    </div>

@endsection