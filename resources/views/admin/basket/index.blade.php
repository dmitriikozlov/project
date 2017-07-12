@extends('admin.layout.index')

@section('content')
    <section>
        <a href="{{ URL::to('/admin/basket/create/') }}">Добавить корзину</a>
        <table>
            <tr>
                <th>Код</th>
                <th>Статус</th>
            </tr>
            @foreach($baskets as $basket)
                <tr>
                    <td>{{ $basket->id }}</td>
                    <td>{{ $basket->status }}</td>
                    <td>
                        <a href="{{ URL::to('/admin/basket/read/') . '/' . $basket->id }}">Показать</a>
                        <a href="{{ URL::to('/admin/basket/update/') . '/' . $basket->id }}">Изменить</a>
                        <a href="{{ URL::to('/admin/basket/delete/') . '/' . $basket->id }}">Удалить</a>
                    </td>
                </tr>
                <tr>
                    <th>Продукты</th>
                </tr>
                @foreach($basket_products as $basket_product)
                    @foreach($products as $product)
                        @if($basket->id == $basket_product->basket_id
                        && $basket_product->product_id == $product->id)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            @endforeach
        </table>
    </section>
@endsection