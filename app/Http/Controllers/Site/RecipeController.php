<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RecipeController extends Controller
{
    public function index($page = null)
    {
        $products = Product::where('type', '!=', 'custom');

        if($page == null)
        {
            $products = $products->paginate($page * 10);

            return view('site.recipe.index', [
                'page' => '1',
                'products' => $products,
            ]);
        }

        if(!(is_integer($page) && $page > 0))
            return redirect('/');

        $products = $products->paginate($page * 10);

        return view('site.recipe.index', [
            'page' => $page,
            'products' => $products,
        ]);
    }

    public function show($id = null)
    {
        if($id == null)
            return redirect('/recipes/');

        $product = Product::find($id);
        if($product == null)
            return redirect('/recipes/');

        return view('site.recipe.show', [
            'product' => $product,
        ]);
    }
}
