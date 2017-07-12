<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Pagination\Paginator;

class SettingController extends Controller
{
    public function show($id = null) {

        $settings = DB::select("
            SELECT *
            FROM `settings`
        ");

        $settings = new Paginator($settings, 10, request()->get('page', 1), []);

        return view('admin.setting.show', [
            'settings' => $settings,
        ]);
    }

    public function output($id = null) {
        $setting = null;

        if($id) {
            $setting = DB::select("
                SELECT *
                FROM `settings`
                WHERE `id` = :id
            ", [
                'id' => $id,
            ]);

            $setting = $setting[0];
        }

        return view('admin.setting.output', [
            'setting' => $setting,
        ]);
    }

    public function input($id = null) {
        $this->validate(request(), [
            'title' => 'required|string|max:255',
            'key'   => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $setting = null;
        if(!$id) {
            $setting = DB::insert("
                INSERT INTO `settings`
                SET `id`    = NULL,
                    `title` = :title,
                    `key`   = :key,
                    `value` = :value
            ", [
                'title' => request()->input('title'),
                'key'   => request()->input('key'),
                'value' => request()->input('value'),
            ]);
        } else {
            $setting = DB::update("
                UPDATE `settings`
                SET `title` = :title,
                    `key`   = :key,
                    `value` = :value
                WHERE `id` = :id
            ", [
                'id'    => $id,
                'title' => request()->input('title'),
                'key'   => request()->input('key'),
                'value' => request()->input('value'),
            ]);
        }

        return redirect()->action('Admin\SettingController@show');
    }

    public function delete($id) {
        DB::delete("
            DELETE FROM `settings`
            WHERE `id` = :id
        ", [
            'id' => $id,
        ]);

        return redirect()->action('Admin\SettingController@show');
    }
}
