@extends('admin.layout.index')

@section('content')
    <section>
        <form action="{{ URL::to('/admin/basket/create/') }}"
              method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">

            <select name="status">
                <option value="framed">Оформлена</option>
                <option value="performed">В обработке</option>
                <option value="done">Выполнена</option>
                <option value="canceled">Отменена</option>
            </select>
            <br><br>
            <input type="submit" value="Создать">
            <br><br>
            <input id="button_product" name="button_product" type="button"
                   onclick="button_product_add('{{ URL::to('/admin/basket/create/product/') }}')" value="Добавить продукт">
            <br><br>
            <section id="content_product">

            </section>
        </form>
    </section>
@endsection