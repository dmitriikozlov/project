@extends('admin.layout.index')

@section('content')
    <section>
        <form action="{{ \URL::to('/admin/size/create/') }}"
              method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="name" type="text" placeholder="Название" required>
            <br><br>
            <input name="weight" type="text" placeholder="Вес" required>
            <br><br>
            <input name="price" type="text" placeholder="Цена" required>
            <br><br>
            <input type="submit" value="Создать">
        </form>
    </section>
@endsection