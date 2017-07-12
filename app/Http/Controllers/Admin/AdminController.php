<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class AdminController extends Controller
{
    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.index');
    }

    public function edit(Request $request, $id) {
        if($request->isMethod('get')) {
            return $this->editGet($id);
        } else {
            return $this->editPost($request, $id);
        }
    }

    public function editGet($id) {
        $user = User::findOrFail($id);

        return view('admin.edit', [
            'user' => $user,
        ]);
    }

    public function editPost(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return redirect()->route('admin.index');
    }

    public function register(Request $request) {
        if($request->isMethod('get')) {
            return $this->registerGet();
        } else {
            return $this->registerPost($request);
        }
    }

    public function registerGet() {
        return view('admin.register');
    }

    public function registerPost(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->save();

        return redirect()->route('admin.index');
    }

    public function index()
    {
        return \View::make('admin.index');
    }

    public function login(Request $request)
    {
        if($request->isMethod('get'))
            return $this->loginGet();
        if($request->isMethod('post'))
            return $this->loginPost($request);
    }

    public function loginGet()
    {
        return \View::make('admin.login');
    }

    public function loginPost(Request $request)
    {
        if($request->has('email') && $request->has('password'))
        {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::all()
                ->where('email', $email)
                ->where('password', $password)->first();

            if($user)
            {
                Auth::login($user);
                return \Redirect::to('/admin/');
            }
            else
                return \Redirect::to('/admin/');

        }
        else
            return \Redirect::to('/admin/');
    }

    public function logout()
    {
        \Auth::logout();

        return \Redirect::to('/admin/');
    }
}
