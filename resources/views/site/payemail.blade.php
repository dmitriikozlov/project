<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Расширенный заказ</title>
    </head>
    <body>
        <h1>Расширенный заказ</h1>
        <table>
            <tr>
                <td>Имя</td>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td>{{ $phone }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $email }}</td>
            </tr>
            <tr>
                <td>Город</td>
                <td>{{ $city }}</td>
            </tr>
            <tr>
                <td>Улица</td>
                <td>{{ $street }}</td>
            </tr>
        </table>
        
        <h3>Товары</h3>
        <table>
            <tr>
                <td>Название</td>
                <td>Цена</td>
                <td>Вес штуки</td>
                <td>Кол-во</td>
            </tr>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->weight }}</td>
                <td>{{ $product->amount }}</td>
            </tr>
            @endforeach
        </table>
        
    </body>
</html>