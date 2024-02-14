<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialEngineController extends Controller
{
    protected $model = Contact::class;

    public function raccomandazioni()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $followings = $user->followings(User::class)->pluck('followable_id');
    
        // Ottieni utenti professionisti seguiti dagli amici dell'utente
        $raccomandazioni = User::whereIn('id', $followings)->where('is_professional', true)->get();
    
        return response()->json($raccomandazioni);
    }
}
