<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Validator;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return View::make('admin.size.index')
            ->with('sizes', $sizes);
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
        return View::make('admin.size.create');
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $size = new Size();
        $size->name = $request->input('name');
        $size->weight = $request->input('weight');
        $size->price = $request->input('price');
        $size->save();

        return Redirect::to('/admin/size/');
    }

    public function read($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/size/');

        $size = Size::all()->find($id);

        if($size)
        {
            return View::make('admin.size.read')
                ->with('size', $size);
        }

        return Redirect::to('/admin/size/');
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
            return Redirect::to('/admin/size/');

        $size = Size::all()->find($id);

        if($size)
        {
            return View::make('admin.size.update')
                ->with('size', $size);
        }

        return Redirect::to('/admin/size/');
    }

    public function updatePost(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $size = Size::all()->find($request->input('id'));
        if($size)
        {
            $size->name = $request->input('name');
            $size->weight = $request->input('weight');
            $size->price = $request->input('price');
            $size->save();
        }

        return Redirect::to('/admin/size/');
    }

    public function delete($id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'required|numeric']);
        if($validator->fails())
            return Redirect::to('/admin/size/');

        $size = Size::all()->find($id);

        if($size)
        {
            $size->delete();
        }

        return Redirect::to('/admin/size/');
    }
}
