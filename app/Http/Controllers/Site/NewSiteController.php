<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Session;
use Exception;

class NewSiteController extends Controller
{
    public function order() {
        $this->validate(request(), [
            'id' => 'required|integer',
        ]);

        $id = request()->input('id');
        $is_new = true;

        if(Session::has("products.$id")) {
            Session::put("products.$id.count", Session::get("products.$id.count") + 1);
            $is_new = false;
        } else {
            Session::put("products.$id.count", 1);
            $is_new = true;
        }

        $product = DB::select("
            SELECT *
            FROM `products`
            WHERE id = $id
        ");
        if(count($product) > 0) {
            $product = $product[0];
            $product->count = Session::get("products.$id.count");
        }
        else
            throw new Exception();

        return response()->json([
            'is_new' => $is_new,
            'id' => $product->id,
            'count' => Session::get("products.$id.count"),
            'price' => $product->price,

            'product_view' => view('site.newsite.basket-item', [
                'product' => $product,
            ])->render(),
        ]);
    }

    public function plus() {
        $this->validate(request(), [
            'id' => 'required|integer',
        ]);

        $id = request()->input('id');

        if(!Session::has("products.$id"))
            throw new Exception();

        Session::put("products.$id.count", Session::get("products.$id.count") + 1);

        $product = DB::select("
            SELECT *
            FROM `products`
            WHERE id = $id
        ");

        if($product)
            $product = $product[0];
        else
            throw new Exception();

        return response()->json([
            'id' => $product->id,
            'count' => Session::get("products.$id.count"),
            'price' => $product->price,
        ]);
    }

    public function minus() {
        $this->validate(request(), [
            'id' => 'required|integer',
        ]);

        $id = request()->input('id');

        if(!Session::has("products.$id"))
            throw new Exception();

        if(Session::get("products.$id.count") > 1)
            Session::put("products.$id.count", Session::get("products.$id.count") - 1);

        $product = DB::select("
            SELECT *
            FROM `products`
            WHERE id = $id
        ");

        if($product)
            $product = $product[0];
        else
            throw new Exception();

        return response()->json([
            'id' => $product->id,
            'count' => Session::get("products.$id.count"),
            'price' => $product->price,
        ]);
    }

    public function remove() {
        $this->validate(request(), [
            'id' => 'required|integer',
        ]);

        $id = request()->input('id');

        Session::forget("products.$id");

        return response()->json([
            'id' => $id,
        ]);
    }
}
