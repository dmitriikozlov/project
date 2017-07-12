<?php
    $products = App\Models\Product::where('type', 'hot')->take(4)->get();
    $orders = [];
    $price = 0;
    $cent = 0;
    $amount = 0;
    $page = \App\Models\Page::where('url','/')->first();

    if(Session::has('products')) {
        $session_products = Session::get('products');
        if(count($session_products) >= 1) {
            $orders = DB::select("
                SELECT *
                FROM `products`
                WHERE id IN (". implode(',', array_keys($session_products)) .")
            ");
        }
        foreach($orders as $order) {
            $order->count = Session::get("products.{$order->id}.count");
            $order->price = $order->price * Session::get("products.{$order->id}.count");
            
            $price += $order->price;
            $amount += $order->count;
        }
        
        $prices = \App\Modules\Price::getPrice($price);
        $price = $prices->left;
        $cent = $prices->right;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    @yield('meta')
    @yield('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/last.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ url('images/fav.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/pizza.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('js/pizza.js') }}"></script>
    <!--[if lt IE 9]>
    <script>
        document.createElement('header');
        document.createElement('nav');
        document.createElement('section');
        document.createElement('article');
        document.createElement('aside');
        document.createElement('footer');
    </script>
    <![endif]-->

    <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter37864800 = new Ya.Metrika({ id:37864800, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/37864800" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-79048210-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>

@include('site.partials.basket', [
    
])

@include('site.partials.header')

    @yield('content')

@include('site.partials.footer')

<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300,300italic,700,700italic,500italic&subset=latin,cyrillic' rel='stylesheet' type='text/css' property="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css' property="stylesheet">
<link rel="stylesheet" href="{{ asset('css/icons.css') }}">
<link href="{{ asset('icomoon/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/colorbox.css') }}">

<script type="text/javascript">
    price_url = '{{ url('/service/price/') }}';
    basket_url = '{{ url('/service/basket/') }}';
    hot_url = '{{ url('/service/hot/') }}';
    category_url = '{{ url('/service/category/') }}';
    product_url = '{{ url('/category/service/products') }}';
    basketprice_url = '{{ url('/service/basketprice/') }}';
    else_url = '{{ url('/service/else/') }}';
    basket_amount_url = '{{ url('basket/amount') }}'

    token = '{{ csrf_token() }}';
</script>
<script type="text/javascript" src="{{ url('js/jquery-1.12.3.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/inputmask.js') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery.inputmask.js') }}"></script>
<script src="{{ asset('/js/inputmask.date.extensions.js') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery.colorbox-min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/site.js') }}"></script>

@include('site.modal.thanks')

</body>
</html>