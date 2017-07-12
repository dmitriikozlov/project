<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ url('/') }}">Rock and Roll</a>
    </div>
    <ul class="nav navbar-nav">
        @if(\Auth::check())
        <li><a href="{{ url('/admin/') }}">Пользователи</a></li>
        <li><a href="{{ url('/admin/ingredient/') }}">Ингредиенты</a></li>
        <!--<li><a href="{{ url('/admin/size/') }}">Размеры</a></li>
        <li><a href="{{ url('/admin/mark/') }}">Маркировка</a></li>-->
        <li><a href="{{ url('/admin/product/') }}">Продукты</a></li>
        <li><a href="{{ url('/admin/category/') }}">Категории</a></li>
        <!--<li><a href="{{ url('/admin/basket/') }}">Корзина</a></li>-->
            <li><a href='{{ url('admin/page') }}'>Статические страницы</a></li>
            <li><a href="{{ action('Admin\PizzaController@show') }}">Пицца</a></li>
            <li><a href="{{ action('Admin\SettingController@show') }}">Настройки</a></li>
            <li><a href="{{ url('/admin/logout/') }}">Выход</a></li>
        @endif
    </ul>
  </div>
</nav>