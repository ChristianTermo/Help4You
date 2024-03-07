<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialEngineController extends Controller
{
    public function raccomandazioni()
    {
        $userId = Auth::user()->id;

        $professionisti = User::where('role', 'Professional')
            ->where(function ($query) use ($userId) {
                $query->whereHas('contacts', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('contacts.user', function ($q) use ($userId) {
                    $q->where('id', $userId);
                });
            })
            ->get();

        return response()->json($professionisti);
    }
}
