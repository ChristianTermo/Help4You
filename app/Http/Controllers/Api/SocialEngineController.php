<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class SocialEngineController extends Controller
{
    public function raccomandazioni(Request $request)
    {
        $url = 'http://doorkeeper.phoney.io:4000/q'; // URL dell'API
        $queryParams = [
            'user_id' => Auth::user()->id,
            'service_id' => $request['service_id'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
        ];

        $response = Http::get($url, $queryParams);

        // Verifica se la richiesta è stata eseguita con successo (status code 2xx)
        if ($response->successful()) {
            // Puoi accedere al corpo della risposta come array JSON
            $responseData = $response->json();

            // Gestisci i dati della risposta come desideri
            return response()->json($responseData);
        } else {
            // Se la richiesta non ha avuto successo, gestisci l'errore
            $errorCode = $response->status();
            $errorMessage = $response->body(); // Testo dell'errore

            // Restituisci una risposta di errore appropriata
            return response()->json(['error' => $errorMessage], $errorCode);
        }
    }
}
