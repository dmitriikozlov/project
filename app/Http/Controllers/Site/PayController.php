<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductMark;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Mail;
use Validator;
use App\User;

class PayController extends Controller
{
    public function payGet() {
        return view('site.pay');
    }
    
    public function payPost(Request $request) {

        $this->validate($request, [
            'city' => 'required|numeric|min:0',
            'street' => 'required|string|min:5',
            'name' => 'required|string|min:3',
            'phone' => 'required|min:10|max:19',
            'email' => 'required|email',
        ]);
        
        // Time delivery
        $time = $request->input("time");
        switch($time) {
            case 0:
                $time = "На ближайшее время";
                break;
            case 1:
                $time = $request->input("time_detail");
                break;
        }
        
        // Adress delivery
        
        $city = $request->input("city");
        $city = config("city")[$city];
        
        $street = $request->input("street");
        
        $house = $request->input("house");
        
        $flat = $request->input("flat");
        
        $access = $request->input("access");
        
        $floor = $request->input("floor");
        
        $code = $request->input("code");
        
        // Contact Information
        
        $name = $request->input("name");
        
        $phone = $request->input("phone");
        
        $email = $request->input("email");
        
        // Payment
        
        $pay = $request->input("pay");
        
        $comment = $request->input("comment");
        
        $call = $request->input("call");
        
        $info = $request->input("info");
        
        // Mail Send
        
        $orders_id = session('order');
        $products = Product::whereIn('id', $orders_id)->get();

        Mail::send('site.payemail', [
            'city' => $city,
            'street' => $street,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'products' => $products
        ], function($message)
        {
            $message->subject('Расширенный заказ');
            $message->from(config('mail.from.address'),config('mail.from.name'));
            $message->to(env('MAIL_ORDERS_ADDRESS'));
        });

        
        $sum = 0;
        foreach($products as $p) {
            $sum += $p->getSum();
        }
        
        if($pay == 1)
        {
            require_once app_path() . '/Privatbank/api.php';
            $public_key = 'i81360119512';
            $private_key = 'enezpwbzJZU35gqO9Rxq7183S1RW1KWkPWhIbz6i';
            $liqpay = new \LiqPay($public_key, $private_key);
            $html = $liqpay->cnb_form(array(
                'amount'         => "$sum",
                'currency'       => 'UAH',
                'description'    => 'Заказ',
                'order_id'       => md5(random_int(1, 100000) . 'asd'),
                'action'         => 'pay',
                'version' => '3',
            ));
            return $html;
            
//            require("api.php"); //Все уже придумано за нас ...
// 
//            $micro = sprintf("%06d",(microtime(true) - floor(microtime(true))) * 1000000); // Ну раз что-то нужно добавить для полной уникализации то ..
//            $number = date("YmdHis"); //Все вместе будет первой частью номера ордера
//            $order_id = $number.$micro; //Будем формировать номер ордера таким образом...
//
//            $merchant_id='iXXXXXXXXXXX'; //Вписывайте сюда свой мерчант
//            $signature="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"; //Сюда вносите public_key
//
//            //$desc = $_GET['desc']; //Можно так принять назначение платежа
//            //$order_id = $_GET['order_id']; //Можно так принять назначение платежа
//            $price = $_GET['price']; //Все что нужно скрипту - передать в него сумму (вы можете передавать все, вплоть до ордера и описания ...)
//
//            $liqpay = new LiqPay($merchant_id, $signature);
//            $html = $liqpay->cnb_form(array(
//             'version' => '3',
//             'amount' => "$price",
//             'currency' => 'USD',     //Можно менять  'EUR','UAH','USD','RUB','RUR'
//             'description' => "Назначение платежа укажите свое",  //Или изменить на $desc
//             'order_id' => $order_id
//             ));

             //echo $html;
        }
        
        return redirect('/');
    }
}
