@extends('admin.layout.index')

@section('content')
    <section>
        <a href="{{ URL::to('/admin/category/create/') }}">Добавить категорию</a>
        <table>
            <tr>
                <th>Код</th>
                <th>Название</th>
            </tr>
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ URL::to('/admin/category/') }}">Категории</a>
                    <a href="{{ URL::to('/admin/category/update/') . '/' . $category->id }}">Изменить</a>
                    <a href="{{ URL::to('/admin/category/delete/') . '/' . $category->id }}">Удалить</a>
                </td>
            </tr>
            <tr>
                <th>Продукты</th>
            </tr>
            @foreach($category_products as $category_product)
                @foreach($products as $product)
                    @if($category->id == $category_product->category_id
                       && $category_product->product_id == $product->id)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </table>
    </section>
@endsection