<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ingredient;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Validator;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->get();
        return View::make('admin.ingredient.index')
            ->with('ingredients', $ingredients);
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
        return View::make('admin.ingredient.create');
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'ispizza' => 'required|boolean',
        ]);

        $ingredient = new Ingredient();
        $ingredient->name = $request->input('name');
        $ingredient->weight = $request->input('weight');
        $ingredient->price = $request->input('price');
        $ingredient->ispizza = $request->input('ispizza');
        $ingredient->filter = $request->input('filter',0);
		if($request->file("image") != null) {
			$ingredient->image = str_random() . $request->file('image')->getClientOriginalName();
			$request->file('image')->move(public_path() . '/uploads/ingredients/',
				$ingredient->image);
		} else {
			$ingredient->image = "";
		}
        $ingredient->save();

        return Redirect::to('/admin/ingredient/');
    }

    public function read($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/ingredient/');

        $ingredient = Ingredient::all()->find($id);

        if($ingredient)
        {
            return View::make('admin.ingredient.read')
                ->with('ingredient', $ingredient);
        }

        return Redirect::to('/admin/ingredient/');
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
            return Redirect::to('/admin/ingredient/');

        $ingredient = Ingredient::all()->find($id);

        if($ingredient)
        {
            return View::make('admin.ingredient.update')
                ->with('ingredient', $ingredient);
        }

        return Redirect::to('/admin/ingredient/');
    }

    public function updatePost(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'ispizza' => 'required|boolean',
        ]);

        $ingredient = Ingredient::all()->find($request->input('id'));
        if($ingredient)
        {
            $ingredient->name = $request->input('name');
            $ingredient->weight = $request->input('weight');
            $ingredient->price = $request->input('price');
            $ingredient->ispizza = $request->input('ispizza');
            $ingredient->filter = $request->input('filter',0);
            if($request->file("image") != null)
            {
                $ingredient->image = str_random() . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path() . '/uploads/ingredients/',
                    $ingredient->image);
            }
            $ingredient->save();
        }

        return Redirect::to('/admin/ingredient/');
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/ingredient/');

        $ingredient = Ingredient::all()->find($id);

        if($ingredient)
        {
            $ingredient->delete();
        }

        return Redirect::to('/admin/ingredient/');
    }
}
