<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mark;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Mark::all();

        return view('admin.mark.index', [
            'marks' => $marks,
        ]);
    }

    public function create(Request $request)
    {
        /* GET */
        if($request->isMethod('get'))
        {
            return view('admin.mark.create');
        }

        /* POST */
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'required|image',
            ]);

            $mark = new Mark();
            $mark->name = $request->input('name');
            $mark->image = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/uploads/marks/',
                $request->file('image')->getClientOriginalName());
            $mark->save();

            return redirect('/admin/mark/');
        }
    }
    
    public function read($id = null)
    {
        $mark = Mark::all()->find($id);
        if(!$mark)
            return redirect('/admin/mark/');

        return view('admin.mark.read', [
            'mark' => $mark,
        ]);
    }

    public function update(Request $request, $id = null)
    {
        /* GET */
        if($request->isMethod('get'))
        {
            $mark = Mark::all()->find($id);
            if(!$mark)
                return redirect('/admin/mark/');

            return view('admin.mark.update', [
                'mark' => $mark,
            ]);
        }

        /* POST */
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'required|image',
            ]);

            $mark = Mark::all()->find($request->input('id'));

            $mark->name = $request->input('name');
            $mark->image = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/uploads/marks/',
                $request->file('image')->getClientOriginalName());

            $mark->save();

            return redirect('/admin/mark/');
        }
    }

    public function delete($id = null)
    {
        $mark = Mark::all()->find($id);
        if(!$mark)
            return redirect('/admin/mark/');
        
        $mark->delete();

        return redirect('/admin/mark/');
    }
}
