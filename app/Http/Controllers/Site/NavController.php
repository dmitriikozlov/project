<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NavController extends Controller
{
    public function aboutUs()
    {
        return view('site.nav.aboutus');
    }

    public function express()
    {
        return view('site.nav.express');
    }

    public function recipes()
    {
        return view('site.nav.recipes');
    }

    public function shares()
    {
        return view('site.nav.shares');
    }

    public function contacts()
    {
        return view('site.nav.contacts');
    }
}
