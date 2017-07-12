<?php

namespace App\Http\Controllers\Site;

use App\Modules\Pizza;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Cookie;
use Session;

class PizzaController extends Controller
{
    public function index() {
        $pizza = DB::select("
            SELECT *
            FROM `pizza`
            WHERE `id` = 1
        ")[0];

        $sizes = DB::select("
            SELECT * 
            FROM `pizza_sizes`
            WHERE `pizza_id` = {$pizza->id} 
            AND `published` = 1
        ");

        if(count($sizes) == 0) {
            $sizes[0] = new \stdClass();
            $sizes[0]->pizza_id = 1;
            $sizes[0]->weight = 0;
            $sizes[0]->price = 0;
            $sizes[0]->dimension = 0;
            $sizes[0]->calories = 0;
            $sizes[0]->position = 0;
            $sizes[0]->published = 1;
        }

        $sizes = array_map(function($item) {
            $left = round($item->price);
            $right = $item->price - $left;
            if($right == 0)
                $right = '00';
            else if($right <= 9)
                $right = '0' . $right;
            $item->price_left = $left;
            $item->price_right = $right;
            return $item;
        }, $sizes);

        $categories = DB::select("
            SELECT *
            FROM `pizza_categories`
            WHERE `pizza_id` = {$pizza->id} 
            AND `published` = 1
        ");

        $category_ids = implode(',', array_map(function ($item) {
            return $item->id;
        }, $categories));

        $ingredients = DB::select("
            SELECT *
            FROM `pizza_ingredients`
            WHERE `pizza_category_id` IN ({$category_ids}) 
            AND `published` = 1
        ");

        $ingredients = array_map(function ($item) {
            $item->name_short = $item->name_full = $item->name;
            if(iconv_strlen($item->name) >= 25) {
                $item->name_short = iconv_substr($item->name, 0, 25, 'UTF-8') . '...';
            }
            $price = preg_split('/\./s', $item->price);
            if(count($price) == 1)
                $price[] = '0';
            if($price[1] == 0)
                $price[1] = '00';
            $item->price_left = $price[0];
            $item->price_right = $price[1];

            return $item;
        }, $ingredients);

        return view('site.pizza.index', [
            'pizza' => $pizza,
            'pizza_sizes'  => $sizes,
            'pizza_categories' => $categories,
            'pizza_ingredients' => $ingredients,
        ]);
    }

    public function order() {
        $data = request()->all();
        $data['count'] = 1;
        $data['order_id'] = md5(mt_rand());
        $data['order_timestamp'] = Carbon::now()->timestamp;
        Session::push('pizza', $data);

        $pizza = Pizza::getPizza();
        $order_id = $data['order_id'];
        $result = [];
        for($i = 0; $i < count($pizza); $i++) {
            if($pizza[$i]->order_id == $order_id) {
                $result = $pizza[$i];
            }
        }

        return response()->json([
            'pizza' => $result,
            'pizza_view' => view('site.pizza.basket-item', [
                'pizza' => $result,
            ])->render(),
        ]);
    }

    public function minus() {
        $order_id = request()->input('order_id');
        $result = [];
        
        for($i = 0; $i < count(Session::get('pizza')); $i++) {
            if(Session::get("pizza.$i.order_id") == $order_id) {
                if(Session::get("pizza.$i.count") > 1)
                    Session::put("pizza.$i.count", Session::get("pizza.$i.count") - 1);
                
                $result = Pizza::getPizza()[$i];
            }
        }

        return response()->json([
            "pizza" => $result,
        ]);
    }

    public function plus() {
        $order_id = request()->input('order_id');
        $result = [];
        
        for($i = 0; $i < count(Session::get('pizza')); $i++) {
            if(Session::get("pizza.$i.order_id") == $order_id) {
                Session::put("pizza.$i.count", Session::get("pizza.$i.count") + 1);
                
                $result = Pizza::getPizza()[$i];
            }
        }

        return response()->json([
            "pizza" => $result,
        ]);
    }

    public function remove() {
        
        $order_id = request()->input('order_id');
        $pizza = [];
        
        foreach(Session::get('pizza') as $k => $v) {
            if($v['order_id'] == $order_id) {
                Session::forget("pizza.$k");
            }
        }
        
        return response()->json([
            
        ]);
    }

    public function clearSession() {
        Session::flush();
        return redirect()->action('Site\PizzaController@index');
    }
}
