<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;
use App\Models\ChMessage;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;


class ChatController extends Controller
{
    public function message(Request $request)
    {
        try {
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
            
        } catch (ValidationException $e) {
            // Eccezione per la validazione dei dati
            return 'Validation error: ' . $e->getMessage();
        } catch (QueryException $e) {
            // Eccezione per errori di query
            return 'Database error: ' . $e->getMessage();
        } catch (\Exception $e) {
            // Cattura altre eccezioni non gestite
            return 'An error occurred while sending the message: ' . $e->getMessage();
        }

        return 'message sent successfully';
    }

    public function retrieveMessages($to_id)
    {
        $message = ChMessage::all()
            ->where('from_id', '=', Auth::user()->id)
            ->where('to_id', '=', $to_id);

        return $message;
    }

    public function averageResponseTime($userId)
    {
        $averageResponseTime = ChMessage::all()
            ->where('user_id', $userId)
            ->avg('response_time');

        return $averageResponseTime;
    }
}
