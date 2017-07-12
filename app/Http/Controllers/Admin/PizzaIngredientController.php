<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use DB;
use Image;

class PizzaIngredientController extends Controller
{

    public function index($id)
    {
        $ingredients = DB::select("
            SELECT *
            FROM `pizza_ingredients`
            WHERE `pizza_category_id` = :id
        ", [
            'id' => $id,
        ]);

        return view('admin.pizza_ingredient.index', [
            'id'          => $id,
            'ingredients' => $ingredients,
        ]);
    }

    public function create($id)
    {
        $ingredient = null;

        return view('admin.pizza_ingredient.edit', [
            'id'         => $id,
            'ingredient' => $ingredient,
        ]);
    }

    public function store($id)
    {
        $this->validate(request(), [
            'name'   => 'required|string|max:255',
            'image'  => 'image',
            'weight' => 'required|numeric|min:0',
            'price'  => 'required|numeric|min:0',
        ]);



        DB::insert("
            INSERT INTO `pizza_ingredients` (`id`, `pizza_category_id`, `name`, `image`, `weight`, `price`, `published`)
            VALUES (NULL, :id, :name, :image, :weight, :price, :published)
        ", [
            'id'        => $id,
            'image'     => 'empty',
            'name'      => request()->input('name'),
            'weight'    => request()->input('weight'),
            'price'     => request()->input('price'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        if(request()->hasFile('image')) {
            $image_name = md5(mt_rand()) . '.' . request()->file('image')->getClientOriginalExtension();
            request()->file('image')->move(public_path('uploads/pizza/ingredients'), $image_name);

            DB::update("
                UPDATE `pizza_ingredients`
                SET `image` = :image
                WHERE `id` = LAST_INSERT_ID()
            ", [
                'image' => $image_name,
            ]);
        }

        return redirect()->action('Admin\PizzaIngredientController@index', ['id' => $id]);
    }

    public function edit($id, $id2)
    {
        $ingredient = DB::select("
            SELECT *
            FROM `pizza_ingredients`
            WHERE `id` = :id
        ", [
            'id' => $id2,
        ]);

        if($ingredient)
            $ingredient = $ingredient[0];
        else
            throw new \Exception("Ошибка!");

        return view('admin.pizza_ingredient.edit', [
            'id'         => $id,
            'ingredient' => $ingredient,
        ]);
    }

    public function update($id, $id2)
    {
        $this->validate(request(), [
            'name'   => 'required|string|max:255',
            'image'  => 'image',
            'weight' => 'required|numeric|min:0',
            'price'  => 'required|numeric|min:0',
        ]);

        DB::update("
            UPDATE `pizza_ingredients` 
            SET `name`      = :name,
                `weight`    = :weight, 
                `price`     = :price,
                `published` = :published
            WHERE `id` = :id
        ", [
            'id'     => $id2,
            'name'   => request()->input('name'),
            'weight' => request()->input('weight'),
            'price'  => request()->input('price'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        if(request()->hasFile('image')) {
            $image_name = md5(mt_rand()) . '.' . request()->file('image')->getClientOriginalExtension();
            request()->file('image')->move(public_path('uploads/pizza/ingredients'), $image_name);

            DB::update("
                UPDATE `pizza_ingredients` 
                SET `image`   = :image
                WHERE `id` = :id
            ", [
                'id'    => $id2,
                'image' => $image_name,
            ]);
        }

        return redirect()->action('Admin\PizzaIngredientController@index', ['id' => $id]);
    }

    public function destroy($id, $id2)
    {
        $ingredient = DB::select("
            SELECT *
            FROM `pizza_ingredients`
            WHERE `id` = :id
        ", [
            'id' => $id2,
        ]);

        if($ingredient) {
            @unlink(public_path('uploads/pizza/ingredients') . '/' . $ingredient[0]->image);
            DB::delete("
                DELETE FROM `pizza_ingredients`
                WHERE `id` = :id
            ", [
                'id' => $id2,
            ]);
        }

        return redirect()->action('Admin\PizzaIngredientController@index', ['id' => $id]);
    }
}
