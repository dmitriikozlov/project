<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductMark;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Session;
use Mail;
use Validator;
use App\User;
use Illuminate\Support\Facades\Log;
use DB;

class SiteController extends Controller
{
    public function feedback(Request $request)
    {
        if($request->isMethod('get'))
        {
            return view('site.feedback', [
                'method' => 'get',
            ]);
        }
        if($request->isMethod('post'))
        {
            $users = User::all();
			$inputs = explode("&", $request->input("data"));
			$name = explode("=", $inputs[0])[1];
			$phone = explode("=", $inputs[1])[1];
			$phone = str_replace('%2B', '+', $phone);
                Mail::send('site.feedback-email', 
				[
					"name" => $name,
					"phone" => $phone,
				], function($message) use ($request)
                {
                    $message->subject('Новый колбэк с сайта!');
                    $message->from(config('mail.from.address'),config('mail.from.name'));
                    $message->to(env('MAIL_ORDERS_ADDRESS'));
                });
				
            /*return view('site.feedback', [
                'method' => 'post',
            ]);*/
        }
        return "true";
    }
    
    public function submit(Request $request) {

        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email') ? $request->input("email") : "Поле не указано";
        $time = $request->input('time');
        if ($time == 0) {
            $time = "Доставить в ближайшее время";
        }
        if ($time == 1) {
            $time = $request->input('time_detail') . ' ' . request()->input('datetime');
        }
		$city = config("countries")[$request->input("city") == -1 ? 0 : $request->input("city")]['title'];
        $street = $request->input("street", "");
        $house = $request->input("house") ? $request->input("house") : "";
        $flat = $request->input("flat") ? $request->input("flat") : "";
        $access = $request->input("access") ? $request->input("access") : "";
        $floor = $request->input("floor") ? $request->input("floor") : "";
        $comment = $request->input("comment") ? $request->input("comment") : "";
        $call = $request->has("call") ? "Перезвонить мне" : "Не перезванивать мне";
        $pay = $request->input("pay");

        $price = 0;
        $bonus = 0;
        
        /* PRODUCT */

        if(Session::has('products')) {
            $product_ids = [];
            foreach (Session::get('products') as $id => $count) {
                $product_ids[] = $id;
            }

            $products = DB::select("
            SELECT *
            FROM `products`
            WHERE `id` IN (" . implode(',', $product_ids) . ")
        ");

            foreach ($products as $product) {
                foreach (Session::get('products') as $key => $value) {
                    if ($product->id == $key) {
                        $product->count = $value['count'];
                        $price += $product->price * $product->count;
                    }
                }
            }
        }
        
        /* PIZZA */
        
        $many_pizza = [];

        if(Session::has('pizza')) {
            foreach (Session::get('pizza') as $p) {
                $pizza = [];

                $pizza_size = DB::select(" 
                SELECT *
                FROM `pizza_sizes`
                WHERE `id` = {$p['size']}
            ")[0];

                $pizza['count'] = $p['count'];

                $pizza['size'] = $pizza_size;

                $ingredient_ids = [];
                $ic = [];

                foreach ($p['ingredients'] as $i) {
                    $ingredient_ids[] = $i['id'];
                    $tic = [];
                    $tic['id'] = $i['id'];
                    $tic['count'] = $i['count'];
                    $ic[] = $tic;
                }

                $ingredients = DB::select("
                SELECT *
                FROM `pizza_ingredients`
                WHERE `id` IN (" . implode(',', $ingredient_ids) . ")
            ");

                for ($i = 0; $i < count($ingredients); $i++) {
                    for ($j = 0; $j < count($ic); $j++) {
                        if ($ingredients[$i]->id == $ic[$j]['id']) {
                            $ingredients[$i]->count = $ic[$j]['count'];
                        }
                    }
                }

                $pizza['ingredients'] = $ingredients;

                $many_pizza[] = $pizza;
            }

            $pizza_result = [];

            foreach ($many_pizza as $p) {
                $result = [];
                $size_price = $p['size']->price;
                $ingredient_price = 0;
                $_name = 'МОЯ ПИЦЦА(';
                foreach ($p["ingredients"] as $i) {
                    $_name .= $i->name . ' ' . ($i->weight * $i->count) . 'г ,';
                    $ingredient_price += $i->price * $i->count;
                }
                $_name .= ')';
                $result['name'] = $_name;
                $result['price'] = $size_price + $ingredient_price;
                $result['count'] = $p['count'];
                $result['price_with_count'] = ($size_price + $ingredient_price) * $p['count'];
                $pizza_result[] = $result;
                $price += $result['price_with_count'];
            }
        }
        
        // LIQPAY

        $html = "";
        $pay_type = 0;
        if ($pay == 0) {
            $html = "<div class='alert'>Заказ принят!</div>";
        }

        if ($pay == 1) {
            require_once app_path() . '/Privatbank/api.php';
            $public_key  = config('countries')[request()->input('city')]['public_key'];
            $private_key = config('countries')[request()->input('city')]['private_key'];
            $liqpay = new \LiqPay($public_key, $private_key);
            $html = $liqpay->cnb_form(array(
                'amount' => $price,
                'currency' => 'UAH',
                'description' => 'Заказ',
                'order_id' => md5(mt_rand(1, 100000)),
                'action' => 'pay',
                'version' => '3',
            ));
            $pay_type = 7;
        }

        $now = Carbon::now();

        $date = null;
        $time = null;

        switch(request()->input('time')) {
            case 0: // В ближайшее время
                $date = Carbon::now()->addMinutes(30)->format('Y-m-d');
                $time = Carbon::now()->addMinutes(30)->format('H:i');
                break;
            case 1: // Указана дата и время
                $date = Carbon::createFromFormat('d.m.Y', request()->input('time_detail'));
                $date = $date->format('Y-m-d');
                $time = request()->input('datetime');
                break;
        }

        $text = '';
        $text .= 'Дата заказа: ' . $now->toDateString() . ';' . "\n";
        $text .= 'Время заказа: ' . $now->format('H:i') . ';' . "\n";
        $text .= 'Дата доставки: ' . $date . ';' . "\n";
        $text .= 'Время доставки: ' . $time . ';' . "\n";
        $text .= 'Комментарий: ' . $comment . $call . ';' . "\n";
        $text .= 'Курьер: ;' . "\n";
        $text .= 'Выписывать чек: 0;' . "\n";
        $text .= 'Отправлять смс при смене статуса: 0;' . "\n";
        $text .= 'Скидка (руб): 0;' . "\n";
        $text .= 'Оплачен: 0;' . "\n";
        $text .= 'Количество персон: 1;' . "\n";
        $text .= 'Вид оплаты: ' . $pay_type . ';' . "\n";
        $text .= 'Продукты меню:' . "\n";
        $text .= '--------------------' . "\n";
        if(Session::has('products')) {
            foreach ($products as $product) {
                $text .= 'Название: ' . $product->name . ', Количество: ' . $product->count .
                    ', Цена: ' . round($product->price) . ', Скидка (%): 0, Сумма: ' . ($product->price * $product->count) . ';' . "\n";
                $bonus += ($product->price * $product->count);
            }
        }
        if(Session::has('pizza')) {
            foreach ($pizza_result as $pr) {
                $text .= 'Название: ' . $pr['name'] . ', Количество: ' . $pr['count'] .
                    ', Цена: ' . round($pr['price']) . ', Скидка (%): 0, Сумма: ' . $pr['price_with_count'] . ';' . "\n";
                $bonus += $result['price_with_count'];
            }
        }
        $text .= '--------------------' . "\n";
        $text .= 'Информация о клиенте:' . "\n";
        $text .= '--------------------' . "\n";
        $phone = preg_replace('/[ \(\)\+\-]/', '', $phone);
        $text .= 'Телефон: ' . $phone . ';' . "\n";
        $text .= 'Мобильный: ;' . "\n";
        $text .= 'Город: ' . $city . ';' . "\n";
        $text .= 'Улица: ' . $street . ';' . "\n";
        $text .= 'Дом: ' . $house . ';' . "\n";
        $text .= 'Квартира: ' . $flat . ';' . "\n";
        $text .= 'Подъезд: 3;' . $access . "\n";
        $text .= 'Этаж: ' . $floor . ';' . "\n";
        $text .= 'Домофон: ' . $access . ';' . "\n";
        $text .= 'Карта: ;' . "\n";
        $text .= 'ФИО: ' . $name . ';' . "\n";
        $text .= 'Организация: ;' . "\n";
        $text .= 'Метро: ;' . "\n";
        $text .= 'Email: ' . $email . ';' . "\n";
        $text .= 'Дополнительно: ;' . "\n";

        Mail::raw($text, function($message) {
            $swiftMessage = $message->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();
            $headers->addTextHeader('Content-Type', 'text/plain; charset=UTF-8');

            $message->subject('Новый заказ с сайта!');
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to(env('MAIL_ORDERS_ADDRESS'));
        });

        $price = 0;
        $amount = 0;
        $cent = '00';

        $products = [];
        
        Session::forget('products');
        Session::forget('pizza');

        $bonus = $bonus / 100 * 10;

        return response()->json([
            'lp' => $pay,
            'pay' => $html,
            'status' => true,
            'amount' => $amount,
            'price' => $price,
            'cent' => $cent,
            'bonus' => $bonus,
        ]);
    }
    
    public function products()
    {
        $products = Product::where('type', '!=', 'custom')->get();
        
        return view('site.products', [
            'products' => $products,
        ]);
    }

    public function index()
    {
        $page = Page::where('url','/')->first();

        $products = DB::table('products as p')
            ->where('p.type', 'hot')->where('p.show', 1)
            ->leftJoin('category_products as cp','cp.product_id','=','p.id')
            ->leftJoin('categories as c','c.id','=','cp.category_id')
            ->take(4)
            ->get(['p.*','c.url as catUrl']);

//        Product::where('type', 'hot')->where('show', 1)->take(4)->get();



        $price = '0';
        $cent = '00';
        $amount = 0;
        $orders = [];
        $all = DB::select(
            "SELECT *
             FROM `products`
            "
        );
        /*
        $all = Product::all();
        */
        if(Session::has('order'))
        {
            foreach(Session::get('order') as $order)
            {
                foreach($all as $p)
                {
                    if($order == $p->id)
                    {
                        $orders[] = $p;
                    }
                }

                $product = Product::find($order);
                $price += $product->getSum();
                $amount += $product->amount;
            }

            $cent = $price - round($price);
            if($cent == 0)
                $cent = '00';
            else if($cent < 10)
                $cent = '0'.$cent;

            $price = round($price);
        }

        // 15:57 16.09.2016

        $orders = [];
        $price = 0;
        $cent = 0;
        $amount = 0;

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
            }
        }

        return view('site.index', [
            'products' => $products,
            'price' => $price,
            'cent' => $cent,
            'amount' => $amount,
            'orders' => $orders,
            'page' => $page
        ]);
    }

    public function hotAjax()
    {
        $hot_products = Product::all()->where('type', 'hot');

        return View::make('site.service.order')
            ->with('products', $hot_products);
    }

    public function topAjax()
    {
        $top_products = Product::all()->where('type', 'top');

        return View::make('site.service.order')
            ->with('products', $top_products);
    }

    public function basket()
    {
        $order_products = [];

        $orders = Session::get('order');
        if($orders)
        {
            foreach ($orders as $id) {
                $product = Product::find($id);
                if ($product)
                    $order_products[] = $product;
            }
        }

        return View::make('site.basket')
            ->with('order_products', $order_products);
    }

    public function basketAjax()
    {
        $order_products = [];

        $orders = Session::get('order');
        if($orders)
        {
            foreach ($orders as $id) {
                $product = Product::find($id);
                if ($product)
                {
                    $order_products[] = $product;
                }
            }
        }

        $products = $order_products;

        return View::make('site.service.basket')
            ->with('products', $products);
    }

    public function basketMinusAjax($id)
    {
        if(!$id)
            return "false";

        $product = Product::all()->find($id);
        if(!$product)
            return "false";

        if($product->price_amount > 1) {
            $product->price_amount--;
            $product->save();
        }
        
        $order_products = [];

        $orders = Session::get('order');
        $price = 0;
        $amount = 0;
        if($orders)
        {
            foreach ($orders as $id) {
                $product = Product::find($id);
                if ($product)
                {
                    $order_products[] = $product;
                    $price += $product->getSum();
                    $amount += $product->price_amount;
                }
            }
        }
        $cent = $price - round($price);
        
        if($cent == 0)
            $cent = '00';
        elseif($cent < 9)
            $cent = '0' . $cent;

        $price = round($price);
        
        $products = $order_products;

        return response()->json([
            'amount' => $amount,
            'price' => $price,
            'cent' => $cent,
            'basket' => view('site.service.basket', [
                'products' => $products
            ])->render(),
            
        ]);
    }

    public function basketPlusAjax($id)
    {
        if(!$id)
            return "false";

        $product = Product::all()->find($id);
        if(!$product)
            return "false";

        $product->price_amount++;
        $product->save();
        
        $order_products = [];

        $orders = Session::get('order');
        $price = 0;
        $amount = 0;
        if($orders)
        {
            foreach ($orders as $id) {
                $product = Product::find($id);
                if ($product)
                {
                    $order_products[] = $product;
                    $price += $product->getSum();
                    $amount += $product->price_amount;
                }
            }
        }
        $cent = $price - round($price);
        
        if($cent == 0)
            $cent = '00';
        elseif($cent < 9)
            $cent = '0' . $cent;

        $price = round($price);
        
        $products = $order_products;

        return response()->json([
            'amount' => $amount,
            'price' => $price,
            'cent' => $cent,
            'basket' => view('site.service.basket', [
                'products' => $products
            ])->render(),
        ]);
    }

    public function basketRemoveAjax($id)
    {
        if(!$id)
            return "false";

        $product = Product::all()->find($id);
        if(!$product)
            return "false";


        $products = Session::get('order');
        
        Session::forget('order');

        foreach($products as $k => $v)
        {
            if($v == $product->id) {
                unset($products[$k]);
                break;
            }
        }

        foreach($products as $k => $v)
        {
            Session::push('order', $v);
        }
        
        $order_products = [];

        $orders = Session::get('order');
        $price = 0;
        if($orders)
        {
            foreach ($orders as $id) {
                $product = Product::find($id);
                if ($product)
                {
                    $order_products[] = $product;
                    $price += $product->getSum();
                }
            }
        }
        $cent = $price - round($price);
        
        if($cent == 0)
            $cent = '00';
        elseif($cent < 9)
            $cent = '0' . $cent;

        $price = round($price);
        
        $products = $order_products;

        return response()->json([
            'amount' => count($products),
            'price' => $price,
            'cent' => $cent,
            'basket' => view('site.service.basket', [
                'products' => $products
            ])->render(),
            
        ]);
    }

    public function priceAjax()
    {
        $price = 0;

        $orders = Session::get('order');

        if($orders)
        {
            foreach ($orders as $id)
            {
                $product = Product::find($id);

                if ($product)
                {
                    //$price += $product->getPrice();
                    $price += $product->price;
                }
            }
        }
        
        return (string)round($price);
    }
    
    public function centAjax()
    {
        $price = 0;

        $orders = Session::get('order');

        if($orders)
        {
            foreach ($orders as $id)
            {
                $product = Product::find($id);

                if ($product)
                {
                    //$price += $product->getPrice();
                    $price += $product->price;
                }
            }
        }
        
        return substr(sprintf('%01.2f', $price), 2);
    }

    public function basketpriceAjax()
    {
        $price = 0;

        $orders = Session::get('order');

        if($orders)
        {
            foreach ($orders as $id)
            {
                $product = Product::find($id);
                if ($product)
                    $price += $product->price;
            }
        }

        return view('site.service.basketprice')
            ->with('price', $price);
    }

    public function orderAjax($id)
    {
        if(!$id)
            return "false";

        $product = Product::all()->find($id);
        if(!$product)
            return "false";
		
        $is_new = true;
        $orders = Session::get('order');
        if($orders) {
            foreach ($orders as $k => $v) {
                $item = Product::all()->find($v);
                if ($item) {
                    if ($product->name == $item->name) {
                        $item->price_amount = 1;
                        $item->save();
                        $is_new = false;
                        break;
                    }
                }
            }
        }
        $product_new = null;
        if($is_new) {
            $product_new = new Product();
            $product_new->name = $product->name;
            $product_new->type = 'custom';
            $product_new->protein = $product->protein;
            $product_new->weight = $product->weight;
            $product_new->price = $product->price;
            $product_new->price_amount = $product->price_amount;
            $product_new->amount = $product->amount;
            $product_new->text_color = $product->text_color;
            $product_new->color = $product->color;
            $product_new->recipe = $product->recipe;
            $product_new->fat = $product->fat;
            $product_new->carbohydrate = $product->carbohydrate;
            $product_new->calory = $product->calory;
            $product_new->joule = $product->joule;
            $product_new->image = $product->image;

            $product_new->mark = $product->mark;
            $product_new->visite = $product->visite;
            $product_new->save();

			$sql = "
				SELECT * 
				FROM `product_ingredients` as pi
				WHERE `pi`.`product_id` = :id
			";
			
			$pis = \DB::select($sql, [
				'id' => $id,
			]);
			
			foreach($pis as $pi) {
				$prod_ing = new ProductIngredient();
                $prod_ing->product_id = $product_new->id;
                $prod_ing->ingredient_id = $pi->ingredient_id;
                $prod_ing->save();
			}
			
			/*
            foreach(ProductIngredient::all() as $pi)
            {
                if($pi->product_id == $id)
                {
                    $prod_ing = new ProductIngredient();
                    $prod_ing->product_id = $product_new->id;
                    $prod_ing->ingredient_id = $pi->ingredient_id;
                    $prod_ing->save();
                }
            }
			*/

            foreach(ProductMark::all() as $pm)
            {
                if($pm->product_id == $id)
                {
                    $product_mark = new ProductMark();
                    $product_mark->product_id = $product_new->id;
                    $product_mark->mark_id = $pm->mark_id;
                    $product_mark->save();
                }
            }

            Session::push('order', $product_new->id);
        }
        
        $price = 0;

        $orders = Session::get('order');

        $products = [];
        
        $amount = 0;
        if($orders)
        {
            foreach ($orders as $id)
            {
                $product = Product::find($id);
				
                if ($product)
                {
                    //$price += $product->getPrice();
                    $price += $product->price;
                    $products[] = $product;
                    $amount += $product->price_amount;
                }
            }
        }
        
        return response()->json([
            'amount' => $amount,
            'price' => round($price),
            'cent' => substr(sprintf('%01.2f', $price), strpos(sprintf('%01.2f', $price), '.')),
            'basket' => view('site.service.basket', [
                'product' => $product_new,
            ])->render(),
        ]);
    }

    public function searchAjax($text)
    {
        $products = Product::all();
        $results = [];
        $text = strtolower($text);
        foreach($products as $product)
        {
            $name = strtolower($product->name);
            if (strstr($name, $text))
                $results[] = $name;
        }
        return View::make('site.service.search')
            ->with('results', $results);
    }

    public function search($text = null)
    {
        $isEmpty = $text == null;
        $results = null;
        if(!$isEmpty)
        {
            $products = Product::all();

            $text = strtolower($text);

            foreach ($products as $product)
            {
                $name = strtolower($product->name);
                if (strstr($name, $text))
                    $results[] = $product;
            }

            if($results)
                $isEmpty = false;
        }

        return View::make('site.search')
            ->with('isEmpty', $isEmpty)
            ->with('products', $results);
    }
    
    public function categoryAjax()
    {
        $categories = Category::all();

        return View::make('site.service.category')
            ->with('categories', $categories);
    }

    public function category($id = null)
    {
        return view('site.category');
    }

    public function basketAmount()
    {
        return count(Session::get('order'));
    }
    
    public function elseGet($count = null)
    {
        if($count == null)
//            $products = Product::where('type', 'hot')->where('show', 1)->get();
            $products = \DB::table('products as p')
                ->where('p.type', 'hot')->where('p.show', 1)
                ->leftJoin('category_products as cp','cp.product_id','=','p.id')
                ->leftJoin('categories as c','c.id','=','cp.category_id')
                ->get(['p.*','c.url as catUrl']);
        else
        {
//            $products = Product::where('type', 'hot')->where('show', 1)->take($count)->get();
            $products = \DB::table('products as p')
                ->where('p.type', 'hot')->where('p.show', 1)
                ->leftJoin('category_products as cp','cp.product_id','=','p.id')
                ->leftJoin('categories as c','c.id','=','cp.category_id')
                ->take($count)
                ->get(['p.*','c.url as catUrl']);
        }
        if($count >= count($products)) {
            $enough = true;
//            $products = Product::where('type', 'hot')->where('show', 1)->get();
            $products = \DB::table('products as p')
                ->where('p.type', 'hot')->where('p.show', 1)
                ->leftJoin('category_products as cp','cp.product_id','=','p.id')
                ->leftJoin('categories as c','c.id','=','cp.category_id')
                ->get(['p.*','c.url as catUrl']);

        }
        else
            $enough = false;
        
        return response()->json([
            'else_content' => view('site.service.else', [
                'products' => $products
            ])->render(),
            'enough' => $enough,
        ]);
    }
}

/**************** SUBMIT ********************/

//            $id = '118546';
//            $wait = '0';
//            $test = '1';
//            $price = sprintf('%01.2f', $price);
//            $card = '5167987208404281';
//            $ccy = 'UAH';
//            $details = 'test';
//            $payment_id = str_random();
//
//            $data =<<< _DATA
//<oper>cmt</oper>
//<wait>$wait</wait>
//<test>$test</test>
//<payment id="$payment_id">
//<prop name="b_card_or_acc" value="$card" />
//<prop name="amt" value="$price" />
//<prop name="ccy" value="$ccy" />
//<prop name="details" value="$details" />
//</payment>
//_DATA;
//            $password = 'S5t5M5894A7YAWBG9JWjYRm8LAO940d3';
//            $signature = sha1(md5($data . $password));
//
//            $xml =<<< _XML
//<?xml version="1.0" encoding="UTF-8"? >
//<request version="1.0">
//  <merchant>
//    <id>$id</id>
//    <signature>$signature</signature>
//  </merchant>
//<data>
//<oper>cmt</oper>
//<wait>$wait</wait>
//<test>$test</test>
//<payment id="$payment_id">
//<prop name="b_card_or_acc" value="$card" />
//<prop name="amt" value="$price" />
//<prop name="ccy" value="$ccy" />
//<prop name="details" value="$details" />
//</payment>
//</data>
//</request>
//_XML;
//            $url = 'https://api.privatbank.ua/p24api/pay_pb';
//
//            $stream_options = array(
//                'http' => array(
//                    'method'  => 'POST',
//                    'header'  => "Content-type: text/xml\r\n",
//                    'content' => $xml,
//                ),
//            );
//
//            $context  = stream_context_create($stream_options);
//            $response = file_get_contents($url, null, $context);
//
//            $response = simplexml_load_string($response);
//            $state = $response->data->payment->attributes()[1];
//            if($state != 1 /* 1 прошла оплата */)
//            {
//                return "Невозможно оплатить";
//            }
            /*
            $users = User::all();
            foreach($users as $user) {
                Mail::send('site.email', [], function($message) use ($user, $request)
                {
                    $message->from('notify@store.loc', $request->input('name') . ' ');

                    $message->to($user->email);
                });
            }
            */