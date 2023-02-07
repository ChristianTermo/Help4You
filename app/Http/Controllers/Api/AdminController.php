<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getPanel()
    {
        return view('adminPanel');
    }

    public function getLogin()
    {
        return view('login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('getPanel')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withSuccess('Login details are not valid');
        //return $token;
    }
}
