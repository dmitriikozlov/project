<?php

require("api.php"); //Все уже придумано за нас ...
 
$micro = sprintf("%06d",(microtime(true) - floor(microtime(true))) * 1000000); // Ну раз что-то нужно добавить для полной уникализации то ..
$number = date("YmdHis"); //Все вместе будет первой частью номера ордера
$order_id = $number.$micro; //Будем формировать номер ордера таким образом...
 
$merchant_id='iXXXXXXXXXXX'; //Вписывайте сюда свой мерчант
$signature="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"; //Сюда вносите public_key
 
//$desc = $_GET['desc']; //Можно так принять назначение платежа
//$order_id = $_GET['order_id']; //Можно так принять назначение платежа
$price = $_GET['price']; //Все что нужно скрипту - передать в него сумму (вы можете передавать все, вплоть до ордера и описания ...)
 
$liqpay = new LiqPay($merchant_id, $signature);
$html = $liqpay->cnb_form(array(
 'version' => '3',
 'amount' => "$price",
 'currency' => 'USD',     //Можно менять  'EUR','UAH','USD','RUB','RUR'
 'description' => "Назначение платежа укажите свое",  //Или изменить на $desc
 'order_id' => $order_id
 ));
 
 echo $html;
 
?>