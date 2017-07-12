<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function index($url) {
        $page = Page::where('url', $url)->first();
        if(!$page)
            abort (404);
        
        return view('site.page.index',compact('page'));
    }

    public function catalogRoot(){
        return redirect('/',301);
    }

    public function catalogRouter($catAlias,$prodAlias = false){

        if(!$prodAlias){
            $cat = new CategoryController();
            return $cat->index($catAlias);
        }else{
            $prod = new ProductController();
            return $prod->index($catAlias,$prodAlias);
        }
    }


}
