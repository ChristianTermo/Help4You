<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    function disableProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->disbled = true;
    }
}
