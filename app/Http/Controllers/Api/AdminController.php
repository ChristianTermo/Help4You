<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function getPanel()
    {
        return view('help4you');
    }

    public function getLogin()
    {
        return view('login');
    }

    public function categories()
    {
        return view('categories.index');
    }

    public function users()
    {
        return view('');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('getPanel')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withErrors('Login details are not valid');
        //return $token;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
