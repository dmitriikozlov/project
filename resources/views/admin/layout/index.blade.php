<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Store</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin.css') }}">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::to('/js/admin.js') }}"></script>
    </head>
    <body>
        <div class="menu">
            @include('admin.layout.nav')
        </div>
        <div class="main">
            @yield('content')
        </div>
    </body>
</html>