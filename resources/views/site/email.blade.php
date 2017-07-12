<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Заказ</title>
    </head>
    <body>
        <h1>Заказ</h1>
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
				<td>Время</td>
				<td>{{ $time }}</td>
			</tr>
			<tr>
				<td>Тип оплаты</td>
				<td>
					@if($pay == 0)
					Наличными
					@endif
					@if($pay == 1)
					Картой
					@endif
				</td>
			</tr>
			<tr>
				<td>Город</td>
				<td>{{ $city }}</td>
			</tr>
			<tr>
				<td>Улица</td>
				<td>{{ $street }}</td>
			</tr>
			<tr>
				<td>Дом</td>
				<td>{{ $house }}</td>
			</tr>
			<tr>
				<td>Квартира</td>
				<td>{{ $flat }}</td>
			</tr>
			<tr>
				<td>Код/Домофон</td>
				<td>{{ $access }}</td>
			</tr>
			<tr>
				<td>Этаж</td>
				<td>{{ $floor }}</td>
			</tr>
			<tr>
				<td>Коментарий</td>
				<td>{{ $comment }}</td>
			</tr>
			<tr>
				<td>Вызов</td>
				<td>{{ $call }}</td>
			</tr>
		</table>
        <table>
			<tr>
				<td></td>
				<td></td>
			</tr>
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
                <td>{{ $product->price_amount }}</td>
            </tr>
            @endforeach
			<tr>
				<td>Общая цена</td>
				<td>{{ $price }}</td>
			</tr>
        </table>
    </body>
</html>