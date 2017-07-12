<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Ingredient;
use App\Models\Mark;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductMark;
use App\Models\Size;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class CategoryController extends Controller
{
    public function index($url = null)
    {
        if(!$url)
			abort(404);
        
        $category = Category::where("url", $url)->first();
        if(!$category)
            abort(404);

        $marks = [];
        $ingredients = [];
        $products = [];

        if(!$category->is_pizza) {
            $products = \DB::table('products as p')
                ->where('cp.category_id', $category->id)
                ->where('p.show', 1)
                ->leftJoin('category_products as cp', 'cp.product_id', '=', 'p.id')
                ->leftJoin('categories as c', 'c.id', '=', 'cp.category_id')
                ->orderBy('p.visite', 'desc')
                ->get(['p.*', 'c.url as catUrl']);
        } else {
            $products = DB::select("
                SELECT p.*, 
                       c.url AS `catUrl`
                FROM `products` AS p
                LEFT JOIN `category_products` AS cp
                  ON cp.product_id = p.id
                LEFT JOIN `categories` AS c
                  ON c.id = cp.category_id
                WHERE p.show = 1
                  AND p.is_pizza = 1
                ORDER BY p.visite DESC
            ");
        }

        $pIds = [];
        $tmarks = [];
        foreach($products as $p){
            $pIds[] = $p->id;
            $tmarks[$p->mark] = $p->mark;
        }
		
        $product_ingredients = ProductIngredient::whereIn('product_id', $pIds)->pluck("ingredient_id")->toArray();
			
		$ingredients = Ingredient::whereIn('id', $product_ingredients)->where('filter',1)->get();
		
//		$tmarks = $products->pluck('mark')->unique()->toArray();

		foreach($tmarks as $tm) {
			$marks[$tm] = config("marks")[$tm];
		}

		
        $isMarks = true;
        if(count($marks) == 0)
            $isMarks = false;
        $isIngredients = true;
        if(count($ingredients) == 0)
            $isIngredients = false;
        
        $isEmpty = count($products) == 0 ? true : false;
        
        return view('site.category.index', [
            'isEmpty' => $isEmpty,
            'isMarks' => $isMarks,
            'isIngredients' => $isIngredients,
            'products' => $products,
            'ingredients' => $ingredients,
            'marks' => $marks,
            'category' => $category,
        ]);
    }
    
    public function productsAjax(Request $request)
    {
        $post = explode('&', $request->input('forms'));
        
        $marks = [];
        $ingredients = [];
        
        foreach($post as $item)
        {
            if(strpos($item, 'marks') !== false)
                    $marks[] = explode('=', $item)[1];
            if(strpos($item, 'ingredients') !== false)
                    $ingredients[] = explode('=', $item)[1];
        }
        $category_id = $request->input('id');
//        $category = Category::find($category_id);
//        $category_products = CategoryProduct::where('category_id', $category_id)->pluck('product_id')->toArray();

        $sorting = $request->input('select');
        switch($sorting) {
            case '1':
                $colon = 'p.weight';
                $order = 'desc';
                break;
            case '2':
                $colon = 'p.weight';
                $order = 'asc';
                break;
            case '3':
                $colon = 'p.price';
                $order = 'desc';
                break;
            case '4':
                $colon = 'p.price';
                $order = 'asc';
                break;
            case '5':
                $colon = 'p.visite';
                $order = 'asc';
                break;
            case '6':
            default:
                $colon = 'p.visite';
                $order = 'desc';
                break;
        }

//        $products = Product::whereIn("id", $category_products)->where('show', 1)->orderBy($colon,$order)->get();

        $products = \DB::table('products as p')
            ->where('cp.category_id',$category_id)
            ->where('p.show', 1)
            ->leftJoin('category_products as cp','cp.product_id','=','p.id')
            ->leftJoin('categories as c','c.id','=','cp.category_id')
            ->orderBy($colon,$order)
            ->get(['p.*','c.url as catUrl']);

        if(count($marks) > 0)
        {
            $product_marks = config("marks");
            $rproducts = [];
			foreach($marks as $m)
			{
				foreach($product_marks as $k => $v)
				{
					if($m == $k)
					{
						foreach($products as $p)
						{
							if($k == $p->mark)
							{
								$rproducts[] = $p;
							}
						}
					}
				}
			}
            $products = $rproducts;
        }

        if(count($ingredients) > 0)
        {
            $product_ingredients = ProductIngredient::all();
            $rproducts = [];
            foreach($products as $p)
            {
                $temp_pi = ['product' => $p, 'ingredient' => []];
                foreach($product_ingredients as $pi)
                {
                    if($pi->product_id == $p->id)
                    {
                        $temp_pi['ingredient'][] = $pi->ingredient_id;
                    }
                }

                $count = 0;
                foreach($temp_pi['ingredient'] as $pi)
                {
                    foreach($ingredients as $i)
                    {
                        if($i == $pi)
                            $count++;
                    }
                }
                if($count == count($ingredients))
                    $rproducts[] = $p;
            }
            $products = $rproducts;
        }

        return view('site.category.service.products', [
                'products' => $products,
//                'category' => $category
            ]);
        

    }
}
