<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Mark;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductController extends Controller
{
    public function index($catAlias,$prodAlias)
    {

//        $category = Category::where("url", $catAlias)->get();
//        $products_ids = \DB::table('category_products')->where('category_id',$category_id)->pluck('product_id');
//        $product = Product::whereIn('id',$products_ids)->where('url', $prodAlias)->first();

        $product = \DB::table('products as p')
            ->where('p.url', $prodAlias)
            ->where('c.url', $catAlias)
            ->leftJoin('category_products as cp','cp.product_id','=','p.id')
            ->leftJoin('categories as c','c.id','=','cp.category_id')
            ->first(['p.*','c.url as catUrl','c.name as catName']);

		if(!$product)
			abort(404);
        $id = $product->id;
		
//
//        $product = Product::find($id);
        if(!$product) 
			return redirect('/');
		
		if($product->show == 0)
			return redirect('/');

        \DB::table('products')->where('id',$id)->increment('visite');
//		$product->visite++;
//		$product->save();

//        $category_products = CategoryProduct::all();
//        $categories = Category::all();
//        $category = null;
//
//        foreach($category_products as $cp)
//        {
//            foreach($categories as $c)
//            {
//                if($cp->category_id == $c->id && $cp->product_id == $product->id)
//                {
//                    $category = $c;
//                }
//            }
//        }

        $pi = \App\Models\ProductIngredient::where('product_id', $product->id)->pluck('ingredient_id')->toArray();
        $ingredients = \App\Models\Ingredient::whereIn('id', $pi)->distinct()->pluck('name');

        
        $product_ids = explode(';', $product->interesting);
        array_pop($product_ids);
        $products = Product::whereIn('id', $product_ids)->get();
        
//        $colors = ['but_bottom1', 'but_bottom2', 'but_bottom3'];

        return view('site.product.index', [
//            'colors' => $colors,
            'products' => $products,
            'product' => $product,
            'ingredients' => $ingredients,
//            'category' => $category,
        ]);
    }

    public function randomAjax() {
        $products = Product::where('type', '!=', 'custom')->take(4)->get();

        shuffle($products);
        
        return view('site.product.random');
    }
}
