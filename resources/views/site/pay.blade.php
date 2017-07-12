@extends('site.layout.index')

@section('content')
<div style="background-color: white;">
    <form id='form_pay' 
          method='post' 
          action='{{ url('pay') }}'
          onsubmit="return form_pay_submit(this)">
        {{ csrf_field() }}
        <div>
            <h2>Время доставки</h2>
            <input name='time' type='radio' value="0" checked>
            <span>На ближайшее время</span><br>
            <input name='time' type='radio' value="1">
            <span>На опредённую дату/время</span>
            <select name='time_detail'>
                <option value='{{ date('d.m.Y', time()) }}'>Сегодня</option>
                <option value='{{ date('d.m.Y', time() + 60 * 60 * 24) }}'>Завтра</option>
                @for($i = 2; $i <= 5; $i++)
                <option value="{{ date('d.m.Y', time() + 60 * 60 * 24 * $i) }}">{{ date('d.m.Y', time() + 60 * 60 * 24 * $i) }}</option>
                @endfor
            </select>
        </div>
        <div>
            <h2>Адрес доставки</h2>
            <span>Город</span><br>
            <select name='city'>
                @for($i = 0; $i < count(config('city')); $i++)
                    <option value='{{ $i }}'>{{ config('city')[$i] }}</option>
                @endfor
            </select><span style="color: red;">*</span><br>
            
            <span>Улица:</span><br>
            <input name='street' type='text' required><span style="color: red;">*</span><br>
            
            <div style="display: inline-block">
                <span>№ дома:</span><br>
                <input name='house' type='text'>
            </div>
            
            <div style="display: inline-block">
                <span>№ квартиры:</span><br>
                <input name='flat' type='text'>
            </div>
            
            <div style="display: inline-block">
                <span>Подьезд:</span><br>
                <input name='access' type='text'>
            </div>
            
            <div style="display: inline-block">
                <span>Этаж:</span><br>
                <input name='floor' type='text'>
            </div>
            
            <div style="display: inline-block">
                <span>Код/домофон:</span><br>
                <input name='code' type='text'>
            </div>
        </div>
        <div>
            <h2>Контактная информация</h2>
            <span>Ваше имя:</span><br>
            <input name='name' type='text' required><span style="color: red;">*</span><br>
            <span>Телефон:</span><br>
            <input id="pay_phone" name='phone' type='tel' required><span style="color: red;">*</span><br>
            <span>Email:</span><br>
            <input name='email' type='email' required><span style="color: red;">*</span>
        </div>
        <div>
            <h2>Оплата</h2>
            <span>Укажите удобный для Вас метод оплаты:</span><br>
            <select name='pay'>
                @for($i = 0; $i < count(config('pay')); $i++)
                    <option value='{{ $i }}'>{{ config('pay')[$i] }}</option>
                @endfor
            </select><br>
            <span>Номер карты</span>
            <input name="card" type="text"><br>
            <span>Коментарий к заказу:</span><br>
            <textarea name='comment'></textarea><br>
            <input name='call' type='checkbox' checked>
            <span>Перезвонить мне после оформления заказа</span><br>
            <input name='info' type='checkbox' style="vertical-align: top">
            <span style="display: inline-block; width: 335px; text-align: justify">Я предоставляю свое согласие на передачу, сбор, обработку, использование, 
                накопление и хранение моих персональных данных с целью их внесения в базу
                персональных данных контрагентов согласно норм 
                <a href="#">действующего законодательства о защите персональных данных</a>
            </span>
        </div>
        <input name="submit" type="submit" value="Заказать">
        <?php
        /*
            require_once app_path() . '/Privatbank/privatbank.php';
            $public_key = 'i66936530302';
            $private_key = 'lWaSltjXt8YoBJigaYBBjYnJzCirxQeAnEsBQ3IN';
            $liqpay = new LiqPay($public_key, $private_key);
                $html = $liqpay->cnb_form(array(
                 'amount'         => '1',
                 'currency'       => 'USD',
                 'description'    => 'description text',
                 'order_id'       => 'order_id_1',
                 'type'           => 'buy',
                 'version' => '3',
                ));
                echo $html;
         * 
         */
            ?>
    </form>
</div>
@stop