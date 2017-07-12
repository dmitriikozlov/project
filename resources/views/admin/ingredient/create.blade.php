@extends('admin.layout.index')

@section('content')
    <style>
        #input_file {
            display: none;
        }
    </style>
    <script>
        window.addEventListener("load", function() {
            document.getElementById("input_button").addEventListener("click", function() {
                document.getElementById("input_file").click();
            });
			
			document.getElementById("ispizzaoff").addEventListener('change', function() {
				var weight = document.getElementById("tr_weight");
				var price = document.getElementById("tr_price");
				var form = document.getElementById("form_ingredient");
				form.weight.value = 0;
				form.price.value = 0;
				weight.style.display = "none";
				price.style.display = "none";
			});
			
			document.getElementById("ispizzaon").addEventListener('change', function() {
				var weight = document.getElementById("tr_weight");
				var price = document.getElementById("tr_price");
				var form = document.getElementById("form_ingredient");
				form.weight.value = 0;
				form.price.value = 0;
				weight.style.display = "table-row";
				price.style.display = "table-row";
			});
        })
    </script>
    
    <div class="container">
        <form action="{{ \URL::to('/admin/ingredient/create/') }}"
              method="post" id="form_ingredient"
              enctype="multipart/form-data">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <table class="table table-hover">
                <tr>
                    <td>Название</td>
                    <td><input name="name" class="form-control" type="text" required></td>
                </tr>
                <tr id="tr_weight" style="display: none;">
                    <td>Вес г.</td>
                    <td><input name="weight" class="form-control" type="text" value="0" required></td>
                </tr>
                <tr id="tr_price" style="display: none;">
                    <td>Цена грн.</td>
                    <td><input name="price" class="form-control" type="text" value="0" required></td>
                </tr>
                <tr>
                    <td>Ингредиент пиццы?</td>
                    <td>
                        <label id="ispizzaon" class="radio-inline"><input name="ispizza" type="radio" value="1">Да</label>
                        <label id="ispizzaoff" class="radio-inline"><input name="ispizza" type="radio" value="0" checked>Нет</label>
                    </td>
                </tr>
                <tr>
                    <td>Изображение</td>
                    <td>
                        <input id="input_file" name="image" type="file">
                        <button id="input_button" class="btn btn-success">Загрузить</button>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <label><input type="checkbox" value="1" name="filter"> Фильтр</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input class="btn btn-primary" type="submit" value="Создать">
                    </td>
                </tr>
            </table>
        </form>
    </div>

@endsection