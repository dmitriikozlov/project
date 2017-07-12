<?php

namespace App\Http\Controllers;

use App\Modules\Pizza;
use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class TestController extends Controller
{
    public function test($value = null) {
        return view('site.modal.thanks');
    }
}