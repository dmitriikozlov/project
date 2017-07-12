@extends('site.layout.index')

@section('content')
    <section>
        <label>Поиск</label>
        <section id="section_search">
            @if($isEmpty)
                Нет результатов
            @else
                @foreach($products as $product)
                    <form>
                        <table class="hot-product-table">
                            <tr>
                                <td colspan="2">
                                    <img class="hot-product-image" width="150" height="120"
                                         src="{{ URL::to('/uploads/products/') . '/' . $product->image }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <label>{{ $product->name }}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>{{ $product->getPrice() }} грн</label>
                                </td>
                                <td style="text-align: right">
                                    <input id="order" name="order" type="button"
                                           onclick="order_click('{{ URL::to('/service/order/') }}', {{ $product->id }})"
                                           value="Заказать">
                                </td>
                            </tr>
                        </table>
                    </form>
                @endforeach
            @endif
        </section>
    </section>
@endsection