<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\TestMail;
class ForgotPasswordController extends Controller
{
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);


        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::to($request->email)->send(new TestMail);

        return 'We have e-mailed your password reset link!';
}
}