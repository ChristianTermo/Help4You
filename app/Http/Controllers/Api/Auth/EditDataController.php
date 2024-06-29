<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OTPNotification;
use App\Models\Otp;
use App\Models\VerificationCode;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Facades\Http;

class EditDataController extends Controller
{

    function updateName(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'cognome' => 'required'
        ]);
        $user = User::find(JWTAuth::user()->id);
        $user->nome = request()->input('nome');
        $user->cognome = request()->input('cognome');
        $user->save();
        return response()->json($user);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function updatePhoneNumber(Request $request)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("44bc4bb2", "fYVcLeo0lMhmtjm1");
        $client = new \Vonage\Client($basic);

        $request->validate([
            'telefono' => 'required|unique:users,telefono'
        ]);

        $telefono = $request->input('telefono');
        $otp = VerificationCode::create([
            'otp' => rand(10000, 99999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        $response = $client->sms()->send(
            new SMS($telefono, 'Help4You', 'Il tuo codice di verifica è:' . "\n" . $otp->otp)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

        User::where('id', '=', Auth::user()->id)->update([
            'telefono' => Hash::make($request['telefono']),
        ]);
    }

    public function resendOtp(Request $request)
    {
        $telefono = $request->input('telefono');
        $user = User::where('telefono', '=', $telefono);
        $otp = VerificationCode::create([
            'telefono' => $request['telefono'],
            'otp' => rand(10000, 99999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        $token = Auth::login($user);

        $message = Http::get('https://www.services.europsms.com/smpp-gateway.php', [
            'op' => 'sendSMS2',
            'smpp_id' => 'christiantermo40@gmail.com',
            'utenti_password' => 'termo',
            'tipologie_sms_id' => '6',
            'destinatari_destination_addr' => $telefono,
            'trasmissioni_messaggio' => 'Il tuo codice di verifica è: ' . $otp->otp,
            'trasmissioni_mittente' => ''
        ]);

        // Restituisce la risposta JSON con l'utente e il token
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function updatePassword(Request $request)
    {
        $request->validate([
            'newPassword' => 'required'
        ]);
        $user = User::find(JWTAuth::user()->id);
        if ($request->input('newPassword') == $user->password) {
            return 'insert a different password';
        } else {
            $user->password = Hash::make(request()->input('newPassword'));
            $user->save();
            return response()->json($user);
        }
    }
}
