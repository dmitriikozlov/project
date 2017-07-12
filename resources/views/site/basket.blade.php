@extends('site.layout.index')

@section('content')
    <section id="ordered">
        @foreach($order_products as $product)
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
                            <!--
                            <input id="order" name="order" type="button"
                                   onclick="section_top_click('{{ URL::to('/service/order/top/') }}', {{ $product->id }})"
                                   value="Заказать">
                                   -->
                        </td>
                    </tr>
                </table>
        @endforeach
    </section>
    <input id="checkout" name="checkout" type="button"
           onclick="alert('Оформленна')" value="Оформить"/>
@endsection