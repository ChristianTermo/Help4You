<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;

class ChatController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);
        $message = event(new Message($request->input('message')));
        return 'message sent successfully';
    }

    public function sendProposal(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'price' => 'required|float',
        ]);
    }
}
