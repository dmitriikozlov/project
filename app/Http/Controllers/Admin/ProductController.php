<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\ProductMark;
use App\Models\ProductSize;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Size;
use App\Models\Meta;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Intervention\Image\Facades\Image;
use View;
use Redirect;
use Validator;

class ProductController extends Controller
{
	public function productAjax() {
		$products = Product::where("type", "!=", "custom")->get();
		return view("admin.product.create.product", [
			'products' => $products,
		]);
	}
	
    public function index()
    {     
        $products = Product::where('type','!=','custom')->paginate(25);

        $product_ids = [];

        foreach($products as $p){
            $product_ids[] = $p->id;
        }

        $categories_ids = \DB::table('category_products')->whereIn('product_id',$product_ids)->get(['category_id','product_id']);

        $pids = [];
        $cids = [];
        foreach($categories_ids as $c){
            $pids[$c->product_id][] = $c->category_id;
            $cids[] = $c->category_id;
        }

        foreach($products as $k => $p){
            $products[$k] = $p;
            $products[$k]->cats = isset($pids[$p->id]) ? $pids[$p->id] : [];
        }

        $categories = Category::whereIn('id',$cids)->pluck('name','id');

        return View::make('admin.product.index')
            ->with('products', $products)
            ->with('categories', $categories);
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
        return View::make('admin.product.create');
    }

    public function createPost(Request $request)
    {
			$product = new Product();

			$product->name = $request->input('name');
                        $product->url = \App\Translit::run($product->name);
			$product->type = $request->input('type');
			$product->protein = $request->input('protein');
			$product->weight = $request->input('weight');
			$product->price = $request->input('price');
			$product->price_amount = 1;
			$product->amount = $request->input('amount');
			$product->text_color = "white";
			$product->color = "white";
			$product->show = $request->input("show");
			$product->fat = $request->input('fat');
			$product->carbohydrate = $request->input('carbohydrate');
			$product->calory = $request->input('calory');
			$product->joule = $request->input('joule');
			$product->recipe = $request->input('recipe');
			$product->mark = $request->input('mark');
		    $product->is_pizza = $request->input('is_pizza');

			$product->interesting = "";
			if($request->has('product'))
			{
				$length = count($request->input('product'));

				for($i = 0; $i < $length; $i++)
				{
					if($request->input("product")[$i] == -1)
						continue;
					
					$id = $request->input('product')[$i];

					$p = Product::find($id);
					
					$product->interesting .= $p->id . ';';
				}
			}
			$product->image = "123";
			$product->save();
			
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $path = public_path('uploads/products');
                $product->image = $product->id.'.'.$image->getClientOriginalExtension();
                Image::make($image->getRealPath())->fit(600,530)->save($path.'/'.$product->image);
                Image::make($image->getRealPath())->fit(380,335)->save($path.'/thumb_'.$product->image);
            }
			
			$product->save();
			
			$product_ingredients = ProductIngredient::where('product_id', $product->id)->get();

			if($request->input('category') != -1)
			{
				$category = Category::find($request->input("category"));

				if($category)
				{
					$cp = new CategoryProduct();
					$cp->product_id = $product->id;
					$cp->category_id = $category->id;
					$cp->save();
				}
			}
			
			if($request->has('ingredient'))
			{
				$length = count($request->input('ingredient'));

				for($i = 0; $i < $length; $i++)
				{
					if($request->input("ingredient")[$i] == -1)
						continue;
					
					$id = $request->input('ingredient')[$i];

					$ingredient = Ingredient::all()->find($id);

					$product_ingredient = new ProductIngredient();
					$product_ingredient->product_id = $product->id;
					$product_ingredient->ingredient_id = $ingredient->id;
					$product_ingredient->save();
				}
			}
			
			$meta = Meta::find($product->meta_id);
			if(!$meta)
				$meta = new Meta();
			$meta->title = $request->input('meta_title', '');
			$meta->description = $request->input('meta_description', '');
			$meta->keywords = $request->input('meta_keywords', '');
			$meta->robots = $request->input('meta_robots', '');
			$meta->save();
			
			$product->meta_id = $meta->id;
			$product->save();

        return Redirect::to('/admin/product/');
    }
    
    public function sizeAjax()
    {
        $sizes = Size::all();

        return View::make('admin.product.create.size')
            ->with('sizes', $sizes);
    }

    public function ingredientAjax()
    {
        $ingredients = Ingredient::all();

        return View::make('admin.product.create.ingredient')
            ->with('ingredients', $ingredients);
    }

    public function read($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/product/');

        $product = Product::all()->find($id);

        if($product)
        {
            $product_sizes = ProductSize::all();

            $sizes = Size::all();

            $product_ingredients = ProductIngredient::all();

            $ingredients = Ingredient::all();

            return View::make('admin.product.read')
                ->with('product', $product)
                ->with('product_sizes', $product_sizes)
                ->with('sizes', $sizes)
                ->with('product_ingredients', $product_ingredients)
                ->with('ingredients', $ingredients);
        }

        return Redirect::to('/admin/product/');
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
            return Redirect::to('/admin/product/');

        $product = Product::all()->find($id);

        if($product)
        {
			$products = Product::where("type", "!=", "custom")->get();
			
			$product_ingredients = ProductIngredient::where('product_id', $product->id)->get();
			
			$ingredients = [];
			foreach($product_ingredients as $pi)
			{
				$item = Ingredient::find($pi->ingredient_id);
				if($item) {
					$ingredients[] = $item; 
				}
			}
			
			$cps = Category::all();
			$cps = CategoryProduct::where("product_id", $product->id)->get();
			if($cps) {
				$cps = $cps->pluck("category_id")->toArray();
				$c = Category::whereIn("id", $cps)->first();
				if(!$c)
					$cs = [];
				else {
					$cs = Category::where("id", "!=", $c->id)->get();
				}
			} else {
				$cps = $c = $cs = [];
			}
			$cs = Category::all();
			
			$is = $product->interesting;
			if($is != "") {
				$is = explode(";", $is);
				array_pop($is);
				
				$is = Product::whereIn("id", $is)->get();
			}
			else {
				$is = [];
			}

            return View::make('admin.product.update')
                ->with('product', $product)
				->with("products", $products)
				->with("interestings", $is)
				->with("category", $c)
				->with("categories", $cs)
                ->with('product_ingredients', $product_ingredients)
                ->with('ingredients', $ingredients);
        }

        return Redirect::to('/admin/product/');
    }

    public function updatePost(Request $request)
    {
		$product = Product::find($request->input("id"));
		if($product)
		{
			$product->name = $request->input('name');
            $product->url = \App\Translit::run($product->name);
			$product->type = $request->input('type');
			$product->protein = $request->input('protein');
			$product->weight = $request->input('weight');
			$product->price = $request->input('price');
			$product->price_amount = 1;
			$product->show = $request->input("show");
			$product->amount = $request->input('amount');
			$product->text_color = "white";
			$product->color = "white";
			$product->fat = $request->input('fat');
			$product->carbohydrate = $request->input('carbohydrate');
			$product->calory = $request->input('calory');
			$product->joule = $request->input('joule');
			$product->recipe = $request->input('recipe');
			$product->mark = $request->input('mark');
            $product->is_pizza = $request->input('is_pizza');
			
			if($request->input('category') != -1)
			{
				\DB::delete("
					DELETE FROM `category_products`
					WHERE `product_id` = :product_id
				", [
					'product_id' => $product->id,
				]);
				
				$category = Category::find($request->input("category"));
				if($category)
				{
					$cp = new CategoryProduct();
					$cp->product_id = $product->id;
					$cp->category_id = $category->id;
					$cp->save();
				}
			}
			
			if($request->has("interesting")) {
				$product->interesting = "";
				
				$is = $request->input("interesting");

				$is = Product::whereIn("id", $is)->get();
				
				if(count($is) == 0)
					$product->interesting = "";
				else {
					foreach($is as $i) {
						$product->interesting .= $i->id . ';';
					}
				}
			}
			
            if($request->hasFile('image')) {
                $image = $request->file('image');
                $path = public_path('uploads/products');
                $product->image = $product->id.'.'.$image->getClientOriginalExtension();
                Image::make($image->getRealPath())->fit(600,530)->save($path.'/'.$product->image);
                Image::make($image->getRealPath())->fit(380,335)->save($path.'/thumb_'.$product->image);
            }
			$product->save();
			
			$product_ingredients = ProductIngredient::where('product_id', $product->id)->get();
			foreach($product_ingredients as $pi)
			{
				$pi->delete();
			}


			if($request->has('ingredient'))
			{
				$length = count($request->input('ingredient'));

                \DB::delete("
                    DELETE FROM `product_ingredients`
                    WHERE `product_id` = :product_id
                ", [
                    'product_id' => $product->id,
                ]);
				
				for($i = 0; $i < $length; $i++)
				{
					$product_ingredient = new ProductIngredient();
					$product_ingredient->product_id = $product->id;
					$product_ingredient->ingredient_id = request()->input('ingredient')[$i];
					$product_ingredient->save();
				}
			}
			
			$meta = Meta::find($product->meta_id);
			if(!$meta)
				$meta = new Meta();
			$meta->title = $request->input('meta_title', '');
			$meta->description = $request->input('meta_description', '');
			$meta->keywords = $request->input('meta_keywords', '');
			$meta->robots = $request->input('meta_robots', '');
			$meta->save();
			
			$product->meta_id = $meta->id;
			$product->save();
			
			return Redirect::to('/admin/product/');
		}

        return Redirect::to('/admin/size/');
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/product/');

        $product = Product::all()->find($id);
		\DB::delete("
			DELETE FROM `products`
			WHERE `id` = :id
		", [
			'id' => $id,
		]);

        return Redirect::to('/admin/product/');
    }
}
