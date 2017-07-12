<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class PizzaSizeController extends Controller
{
    public function index($pizza_id)
    {
        $sizes = DB::select("
            SELECT *
            FROM `pizza_sizes`
            WHERE `pizza_id` = :id
        ", [
            'id' => $pizza_id,
        ]);

        return view('admin.pizza_size.index', [
            'pizza_id' => $pizza_id,
            'sizes'    => $sizes,
        ]);
    }

    public function create($pizza_id)
    {
        $size = null;
        $position_count = DB::select('SELECT COUNT(*) AS `count` FROM `pizza_sizes`')[0]->count;

        return view('admin.pizza_size.edit', [
            'pizza_id'       => $pizza_id,
            'size'           => $size,
            'position_count' => $position_count
        ]);
    }

    public function store($pizza_id)
    {
        $this->validate(request(), [
            'weight'    => 'required|numeric|min:0',
            'price'     => 'required|numeric|min:0',
            'dimension' => 'required|numeric|min:0',
        ]);

        DB::insert("
            INSERT INTO `pizza_sizes`
            SET `id` = NULL,
                `pizza_id`  = :pizza_id,
                `weight`    = :weight,
                `price`     = :price,
                `dimension` = :dimension,
                `published` = :published
        ", [
            'pizza_id'  => $pizza_id,
            'weight'    => request()->input('weight'),
            'price'     => request()->input('price'),
            'dimension' => request()->input('deminsion'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        return redirect()->action('Admin\PizzaSizeController@index', ['id' => $pizza_id]);
    }

    public function edit($pizza_id, $size_id)
    {
        $size = DB::select("
            SELECT *
            FROM `pizza_sizes`
            WHERE `id` = :size_id
        ", [
            'size_id' => $size_id,
        ]);

        $position_count = DB::select('SELECT COUNT(*) AS `count` FROM `pizza_sizes`')[0]->count;

        if($size)
            $size = $size[0];
        else
            throw new \Exception("SizeController: \n" . __FILE__ . "\n" . __LINE__);

        return view('admin.pizza_size.edit', [
            'pizza_id'       => $pizza_id,
            'size'           => $size,
            'position_count' => $position_count,
        ]);
    }

    public function update($pizza_id, $size_id)
    {
        $this->validate(request(), [
            'weight'    => 'required|numeric|min:0',
            'price'     => 'required|numeric|min:0',
            'dimension' => 'required|numeric|min:0',
        ]);
		
        DB::update("
            UPDATE `pizza_sizes` 
            SET `weight`    = :weight,
                `price`     = :price, 
                `published` = :published,
                `dimension` = :dimension
            WHERE `id` = :size_id
        ", [
            'size_id'   => $size_id,
            'weight'    => request()->input('weight'),
            'price'     => request()->input('price'),
            'dimension' => request()->input('dimension'),
            'published' => request()->has('published') ? 1 : 0,
        ]);

        return redirect()->action('Admin\PizzaSizeController@index', ['id' => $pizza_id]);
    }

    public function destroy($pizza_id, $size_id)
    {
        $size = DB::select("
            SELECT *
            FROM `pizza_sizes`
            WHERE `id` = :size_id
        ", [
            'size_id' => $size_id,
        ]);

        if($size) {
            DB::delete("
                DELETE FROM `pizza_sizes`
                WHERE `id` = :size_id
            ", [
                'size_id' => $size_id,
            ]);
        }

        return redirect()->action('Admin\PizzaSizeController@index', ['id' => $pizza_id]);
    }
}
