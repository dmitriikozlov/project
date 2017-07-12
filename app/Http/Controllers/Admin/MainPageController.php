<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;

class MainPageController extends Controller
{

    public function output($id = 666) {

        $meta = DB::select("
            SELECT *
            FROM `metas`
            WHERE `id` = :id
        ", [
            'id' => $id,
        ]);

        if(count($meta) == 0) {
            DB::insert("
                INSERT INTO `metas`
                SET `id`          = 666,
                    `title`       = 'title',
                    `keywords`    = 'keywords',
                    `description` = 'description',
                    `robots`      = 'index,follow'
            ");

            $meta = DB::select("
                SELECT *
                FROM `metas`
                WHERE `id` = :id
            ", [
                'id' => $id,
            ]);
        }

        $meta = $meta[0];

        return view('admin.main-page.output', [
            'meta' => $meta,
        ]);
    }

    public function input($id = 666) {
        $this->validate(request(), [
            'title'       => 'required|string|max:255',
            'keywords'    => 'required|string',
            'description' => 'required|string',
            'robots'      => 'required|string',
        ]);

        DB::update("
            UPDATE `metas`
            SET `title`       = :title,
                `keywords`    = :keywords,
                `description` = :description,
                `robots`      = :robots
            WHERE `id` = :id
        ", [
            'id'          => $id,
            'title'       => request()->input('title'),
            'keywords'    => request()->input('keywords'),
            'description' => request()->input('description'),
            'robots'      => request()->input('robots'),
        ]);

        return redirect()->action('Admin\SettingController@show');
    }
}
