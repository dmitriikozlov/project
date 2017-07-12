<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Meta;

use App\Models\Page;
use Intervention\Image\Facades\Image;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'url' => 'required|string',
            'content' => 'required|string',
        ]);
        
        $page = new Page();
        $page->title = $request->input('title');
        $page->url = $request->input('url');
        $page->content = $request->input('content');
        $page->save();

        if($request->hasFile('image')) {
            $path = public_path('/uploads/pages/');
            $image = $request->file('image');
            $filename = $page->id.'.'.$image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(275, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$filename);

            $page->image = $filename;
            $page->save();
        }
		
		$meta = Meta::find($page->meta_id);
		if(!$meta)
			$meta = new Meta();
		$meta->title = $request->input('meta_title', '');
		$meta->description = $request->input('meta_description', '');
		$meta->keywords = $request->input('meta_keywords', '');
		$meta->robots = $request->input('meta_robots', '');
		$meta->save();
			
		$page->meta_id = $meta->id;
		$page->save();
        
        return redirect('admin/page');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);
        
        return view('admin.page.show', [
            'page' => $page,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        
        return view('admin.page.edit', [
            'page' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'url' => 'required|string',
            'content' => 'required|string',
        ]);
        
        $page = Page::findOrFail($id);
        $page->title = $request->input('title');
        $page->url = $request->input('url');
        $page->content = $request->input('content');

        $path = public_path('uploads/pages/');
        if($request->hasFile('image')) {

            $image = $request->file('image');
            $filename = $page->id.'.'.$image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(275, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$filename);
            $page->image = $filename;
        }elseif($request->input('delete_image',0)){
            unlink($path.$page->image);
            $page->image = null;
        }
        $page->save();
		
		$meta = Meta::find($page->meta_id);
		if(!$meta)
			$meta = new Meta();
		$meta->title = $request->input('meta_title', '');
		$meta->description = $request->input('meta_description', '');
		$meta->keywords = $request->input('meta_keywords', '');
		$meta->robots = $request->input('meta_robots', '');
		$meta->save();
			
		$page->meta_id = $meta->id;
		$page->save();
        
        return redirect('admin/page');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        
        return redirect('admin/page');
    }
}
