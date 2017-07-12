<?php

namespace App\Http\Controllers\Admin;

use App\Models\Basket;
use App\Models\BasketProduct;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Redirect;
use View;
use Validator;

class BasketController extends Controller
{
    public function index()
    {
        $baskets = Basket::all();
        $basket_products = BasketProduct::all();
        $products = Product::all();
        return View::make('admin.basket.index')
            ->with('baskets', $baskets)
            ->with('basket_products', $basket_products)
            ->with('products', $products);
    }

    public function create(Request $request)
    {
        if($request->isMethod('get'))
            return $this->createGet();
        if($request->isMethod('post'))
            return $this->createPost($request);
    }

    public function createGet()
    {
        $products = Product::all();

        return View::make('admin.basket.create')
            ->with('products', $products);
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|string',
        ]);
        /*
         * <option value="framed">Оформлена</option>
                <option value="performed">В обработке</option>
                <option value="done">Выполнена</option>
         */

        $basket = new Basket();
        $basket->status = $request->input('status');
        $basket->save();

        if($request->has('product'))
        {
            $length = count($request->input('product'));

            for($i = 0; $i < $length; $i++)
            {
                $product = Product::all()->find($request->input('product')[$i]);

                if($product)
                {
                    $basket_product = new BasketProduct();
                    $basket_product->product_id = $product->id;
                    $basket_product->basket_id = $basket->id;
                    $basket_product->save();
                }
            }
        }

        return Redirect::to('/admin/basket/');
    }

    public function productAjax()
    {
        $products = Product::all();

        return View::make('admin.basket.create.product')
            ->with('products', $products);
    }

    public function read($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/basket/');

        $basket = Basket::all()->find($id);

        if($basket)
        {
            $basket_products = CategoryProduct::all();
            $products = Product::all();

            return View::make('admin.basket.read')
                ->with('category', $basket)
                ->with('category_products', $basket_products)
                ->with('products', $products);
        }

        return Redirect::to('/admin/basket/');
    }

    public function update(Request $request, $id = null)
    {
        if($request->isMethod('get'))
            return $this->updateGet($id);
        if($request->isMethod('post'))
            return $this->updatePost($request);
    }

    public function updateGet($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/basket/');

        $basket = Basket::all()->find($id);

        if($basket)
        {
            $category_products = CategoryProduct::all();
            $products = Product::all();

            return View::make('admin.basket.update')
                ->with('basket', $basket)
                ->with('basket_products', $basket_products)
                ->with('products', $products);
        }

        return Redirect::to('/admin/basket/');
    }

    public function updatePost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $basket = Basket::all()->find($request->input('id'));
        $basket->status = $request->input('status');
        $basket->save();

        if($request->has('product'))
        {
            $length = count($request->input('product'));

            for($i = 0; $i < $length; $i++)
            {
                $product = Product::all()->find($request->input('product')[$i]);

                $basket_products = BasketProduct::all();
                $continue = false;
                foreach($basket_products as $basket_product)
                {
                    if($basket_product->product_id == $product->id
                        && $basket_product->basket_id == $basket->id)
                        $continue = true;
                }
                if($continue)
                    continue;

                if($product)
                {
                    $basket_product = new CategoryProduct();
                    $basket_product->product_id = $product->id;
                    $basket_product->basket_id = $basket->id;
                    $basket_product->save();
                }
            }
        }

        return Redirect::to('/admin/basket/');
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/basket/');

        $basket = Basket::all()->find($id);

        if($basket)
        {
            $basket_products = Basket::all();
            foreach($basket_products as $basket_product)
            {
                if($basket_product->basket_id == $basket->id)
                    $basket_product->delete();
            }
            $basket->delete();
        }

        return Redirect::to('/admin/basket/');
    }
}
