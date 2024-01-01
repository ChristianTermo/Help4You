<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SupportMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MeController extends Controller
{
    function disableProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->disbled = true;

        return $user;
    }

    public function submitSupportForm(Request $request)
    {
        Mail::to("support@mail.it")->send(new SupportMail);

        return 'We have e-mailed!';
    }
}
