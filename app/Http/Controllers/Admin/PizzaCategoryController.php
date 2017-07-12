<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class PizzaCategoryController extends Controller
{

    public function index()
    {
        $categories = DB::select("
            SELECT *
            FROM `pizza_categories`
            WHERE `pizza_id` = 1
        ");

        return view('admin.pizza_category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $category = null;

        return view('admin.pizza_category.edit', [
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        DB::insert("
            INSERT INTO `pizza_categories` (id, pizza_id, name, published)
            VALUES (NULL, 1, :name, :published)
        ", [
            'name'      => request()->input('name'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        return redirect()->action('Admin\PizzaCategoryController@index');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $category = DB::select("
            SELECT *
            FROM `pizza_categories`
            WHERE `id` = :id
        ", [
            'id' => $id,
        ])[0];

        return view('admin.pizza_category.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        DB::update("
            UPDATE `pizza_categories` 
            SET `name`      = :name,
                `published` = :published
            WHERE `id` = :id
        ", [
            'id'        => $id,
            'name'      => request()->input('name'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        return redirect()->action('Admin\PizzaCategoryController@index');
    }

    public function destroy($id)
    {
        $category = DB::select("
            SELECT *
            FROM `pizza_categories`
            WHERE `id` = :id
        ", [
            'id' => $id,
        ]);

        if($category) {
            DB::delete("
                DELETE FROM `pizza_categories`
                WHERE `id` = :id
            ", [
                'id' => $id,
            ]);
        }

        return redirect()->action('Admin\PizzaCategoryController@index');
    }
}
