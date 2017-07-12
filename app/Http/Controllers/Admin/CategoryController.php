<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Meta;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Intervention\Image\Facades\Image;
use Redirect;
use View;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('position')->get();
        return View::make('admin.category.index')
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
        $products = Product::all();

        return View::make('admin.category.create')
            ->with('products', $products);
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->url = \App\Translit::run($category->name);
        $category->class = $request->input('class');
		$category->text = $request->input('text');
		$category->show = $request->input('show');
		$category->position = $request->input('position');
        $category->is_pizza = $request->input('is_pizza');

        $category->save();

        if($request->hasFile('image')) {
            $path = public_path('/uploads/categories/');
            $image = $request->file('image');
            $filename = $category->id.'.'.$image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(275, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$filename);

            $category->image = $filename;
            $category->save();
        }

        if($request->has('product'))
        {
            $length = count($request->input('product'));

            for($i = 0; $i < $length; $i++)
            {
				if($request->input('product')[$i] == -1)
					continue;
                $product = Product::find($request->input('product')[$i]);
                if($product)
                {
                    $category_product = new CategoryProduct();
                    $category_product->product_id = $product->id;
                    $category_product->category_id = $category->id;
                    $category_product->save();
                }
            }
        }
		
		$meta = Meta::find($category->meta_id);
		if(!$meta)
			$meta = new Meta();
		$meta->title = $request->input('meta_title', '');
		$meta->description = $request->input('meta_description', '');
		$meta->keywords = $request->input('meta_keywords', '');
		$meta->robots = $request->input('meta_robots', '');
		$meta->save();
			
		$category->meta_id = $meta->id;
		$category->save();

        return Redirect::to('/admin/category/');
    }
    
    public function productAjax()
    {
        $products = Product::where('type', '!=', 'custom')->get();

		return response()->json([
			'content' => view('admin.category.create.product', [
				'products' => $products,
			])->render(),
		]);
    }

    public function read($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/category/');

        $category = Category::all()->find($id);

        if($category)
        {
            $category_products = CategoryProduct::all();
            $products = Product::all();

            return View::make('admin.category.read')
                ->with('category', $category)
                ->with('category_products', $category_products)
                ->with('products', $products);
        }

        return Redirect::to('/admin/category/');
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
            return Redirect::to('/admin/category/');

        $category = Category::all()->find($id);

        if($category)
        {
            $category_products = CategoryProduct::where('category_id', $category->id)->get();
			$products = [];
			foreach($category_products as $cp)
			{
				$item = Product::find($cp->product_id);
				if($item) {
					$products[] = $item;
				}
			}

            return View::make('admin.category.update')
                ->with('category', $category)
                ->with('category_products', $category_products)
                ->with('products', $products);
        }

        return Redirect::to('/admin/category/');
    }

    public function updatePost(Request $request)
    {
        $category = Category::find($request->input('id'));
        $category->name = $request->input('name');
        $category->url = \App\Translit::run($category->name);
        $category->class = $request->input('class');
		$category->text = $request->input('text');
		$category->show = $request->input('show');
		$category->position = $request->input('position');
        $category->is_pizza = $request->input('is_pizza');

        $path = public_path('uploads/categories/');
        if($request->hasFile('image')) {

            $image = $request->file('image');
            $filename = $category->id.'.'.$image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(275, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$filename);
            $category->image = $filename;
        }elseif($request->input('delete_image',0)){
            unlink($path.$category->image);
            $category->image = null;
        }
        $category->save();

		$category_products = CategoryProduct::where('category_id', $category->id)->get();
		foreach($category_products as $cp)
			$cp->delete();

        if($request->has('product'))
        {
            $length = count($request->input('product'));

            for($i = 0; $i < $length; $i++)
            {
				if($request->input('product')[$i] == -1)
					continue;
                $product = Product::find($request->input('product')[$i]);

                if($product)
                {
                    $category_product = new CategoryProduct();
                    $category_product->product_id = $product->id;
                    $category_product->category_id = $category->id;
                    $category_product->save();
                }
            }
        }
		
		$meta = Meta::find($category->meta_id);
		if(!$meta)
			$meta = new Meta();
		$meta->title = $request->input('meta_title', '');
		$meta->description = $request->input('meta_description', '');
		$meta->keywords = $request->input('meta_keywords', '');
		$meta->robots = $request->input('meta_robots', '');
		$meta->save();
			
		$category->meta_id = $meta->id;
		$category->save();

        return Redirect::to('/admin/category/');
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/category/');

        $category = Category::all()->find($id);

        if($category)
        {
            $category_products = Category::all();
            foreach($category_products as $category_product)
            {
                if($category_product->id == $category->id)
                    $category_product->delete();
            }
            $category->delete();
        }

        return Redirect::to('/admin/category/');
    }
}
