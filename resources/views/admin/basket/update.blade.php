@extends('admin.layout.index')

@section('content')
    <section>
        <form action="{{ URL::to('/admin/category/update/') }}"
              method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="id" type="hidden" value="{{ $category->id }}">
            <input name="name" type="text" placeholder="Название категории" value="{{ $category->name }}">
            <br><br>
            <input type="submit" value="Изменить">
            <br><br>
            <input id="button_product" name="button_product" type="button"
                   onclick="button_product_add('{{ URL::to('/admin/category/create/product/') }}')" value="Добавить продукт">
            <br><br>
            <section id="content_product">
                @foreach($category_products as $category_product)
                    @foreach($products as $product)
                        @if($category_product->category_id == $category->id
                        && $category_product->product_id == $product->id)
                            <select name="product[]">
                                <option value="{{ $product->id }}">
                                    {{ $product->id }} | {{ $product->name }}
                                </option>
                            </select>
                            <br><br>
                        @endif
                    @endforeach
                @endforeach
            </section>
        </form>
    </section>
@endsection