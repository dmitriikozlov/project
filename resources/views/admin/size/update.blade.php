@extends('admin.layout.index')

@section('content')
    <section>
        <form action="{{ \URL::to('/admin/size/update/') }}"
              method="post"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <input name="id" type="hidden" value="{{ $size->id }}">
            <input name="name" type="text" placeholder="Название" value="{{ $size->name }}" required>
            <br><br>
            <input name="weight" type="text" placeholder="Вес" value="{{ $size->weight }}" required>
            <br><br>
            <input name="price" type="text" placeholder="Цена" value="{{ $size->price }}" required>
            <br><br>
            <input type="submit" value="Изменить">
        </form>
    </section>
@endsection