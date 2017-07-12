<?php

namespace App\Http\Controllers\Site;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('get'))
            return view('site.search.index',['text'=>null]);
        if($request->isMethod('post'))
        {

            $this->validate($request,[
                'text'=>'required|min:2'
            ]);

            $text = $request->input('text');
			
			$products = DB::table('products as p')
			 	->where('p.type', '!=', 'custom')->where('p.show', 1)
			 	->leftJoin('category_products as cp','cp.product_id','=','p.id')
			 	->leftJoin('categories as c','c.id','=','cp.category_id')
			 	->where('p.name', 'LIKE', '%' . $text . '%')
			 	->get(['p.*','c.url as catUrl']);

            return view('site.search.index', [
                'products' => $products, //$result,
                'text'=> $text
            ]);
        }
    }

    public function find(Request $request)
    {
        try {
            $products = Product::where('show', 1)->get();
            $text = $request->input('text');
            $result = [];
            if (strlen($text) > 2) {
                if ($text != '') {
                    foreach ($products as $product) {
                        if ($product->type == 'custom')
                            continue;
                        if (strpos(' ' . strtolower($product->name), strtolower($text)) != false) {
                            $result[] = $product;
                        }
                    }
                }
            }
            else
                return "null";
        }
        catch(Exception $e)
        {
            return "null";
        }
        if(count($result) == 0)
            return "null";
        return view('site.search.find', [
            'products' => $result,
        ]);
    }
}
