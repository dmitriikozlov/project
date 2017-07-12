<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Session;

class PizzaController extends Controller
{
    public function show() {
        $pizza = DB::select("
            SELECT *
            FROM `pizza`
            WHERE `pizza`.id = 1
        ");
        if(!$pizza) {
            DB::insert("
                INSERT INTO `pizza` (`id`, `recipe`)
                VALUES (1, ' ')
            ");

            $pizza = DB::select("
                SELECT *
                FROM `pizza`
                WHERE `pizza`.id = 1
            ");
        }

        $pizza = $pizza[0];

        return view('admin.pizza.show', [
            'pizza' => $pizza,
        ]);
    }

    public function save() {
        $this->validate(request(), [
            'recipe'           => 'required',
            'recipe_published' => 'required|in:0,1',
        ]);

        DB::update("
            UPDATE `pizza`
            SET `recipe`           = :recipe,
                `recipe_published` = :recipe_published,
                `ingredients`      = :ingredients
            WHERE `id` = 1
        ", [
            "recipe"           => request()->input('recipe'),
            "recipe_published" => request()->input('recipe_published'),
            "ingredients"      => request()->input('ingredients'),
        ]);

        return redirect()->action('Admin\PizzaController@show');
    }
}
