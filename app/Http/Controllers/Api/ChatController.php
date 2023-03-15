<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;
use App\Models\ChMessage;

class ChatController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'to_id' => 'required',
            'message' => 'required',
        ]);

        $message = ChMessage::create([
            'from_id' => Auth::user()->id,
            'to_id' => $request->input('to_id'),
            'body' => $request->input('message'),
        ]);
        
        if ($message != null) {
            event(new Message($request->input('message')));
        }

        return 'message sent successfully';
    }

    public function retrieveMessages($to_id)
    {
       $message = ChMessage::all()
       ->where('from_id', '=', Auth::user()->id)
       ->where('to_id' ,'=' ,$to_id);

       return $message;
    }
}
