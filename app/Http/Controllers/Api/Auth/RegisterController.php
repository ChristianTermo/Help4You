<?php

namespace App\Http\Controllers\Api\Auth;


use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PhpParser\Node\Expr\Cast\String_;
use Spatie\Permission\Traits\HasRoles;
use Vonage\SMS\Message\SMS;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Cast\Object_;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request, User $user)
    {
        $basic  = new \Vonage\Client\Credentials\Basic("44bc4bb2", "fYVcLeo0lMhmtjm1");
        $client = new \Vonage\Client($basic);

        $user = User::create([
            // 'nome' => $request['nome'],
            //'cognome' => $request['cognome'],
            'telefono' => Hash::make($request['telefono']),
            // 'email' => $request['email'],
            //'password' => Hash::make($request['password']),
            'role' => $request['role'],
            //  'avatar' => $request['avatar']
        ]);
        $user->assignRole('Regular User');

        //  dd($user);
        $otp = VerificationCode::create([
            'telefono' => $request['telefono'],
            'otp' => rand(10000, 99999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

         $telefono = $request->input('telefono');
        /*$response = $client->sms()->send(
            new SMS($telefono, 'Help4You', 'Il tuo codice di verifica è:' . $otp->otp)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }*/
    
        $response = Http::get('https://www.services.europsms.com/smpp-gateway.php', [
            'op' => 'sendSMS2',
            'smpp_id' => 'christiantermo40@gmail.com',
            'utenti_password' => 'termo',
            'tipologie_sms_id' => '6',
            'destinatari_destination_addr' => $telefono,
            'trasmissioni_messaggio' => 'Il tuo codice di verifica è: ' . $otp->otp,
            'trasmissioni_mittente' => ''
        ]);

        $url = 'http://doorkeeper.phoney.io:4000/u';
        $data = [
            'id' => 'value1',
            'latitude' => 'value2',
            'longitude' => 'value2',
            'services' => 'value2',
            'contacts' => 'value2',
        ];

        $response = Http::post($url, $data);

        if ($response->successful()) {

            $responseData = $response->json();
            return response()->json($responseData);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->body();

            echo 'error ' . $errorMessage . "" . $errorCode;
        }

        return response()->json($user);
    }


    public function registerProfessional(RegisterRequest $request, User $user)
    {
        // Verifica se l'utente esiste già
        $existingUser = User::where('telefono', $request['telefono'])->first();

        if ($existingUser) {
            // Se l'utente esiste già, invia direttamente l'OTP
            $otp = VerificationCode::create([
                'telefono' => $request['telefono'],
                'otp' => rand(10000, 99999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);

            $basic  = new \Vonage\Client\Credentials\Basic("44bc4bb2", "fYVcLeo0lMhmtjm1");
            $client = new \Vonage\Client($basic);

            $response = $client->sms()->send(
                new SMS($request['telefono'], 'Help4You', 'Il tuo codice di verifica è:' . $otp->otp)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                echo "The message was sent successfully\n";
            } else {
                echo "The message failed with status: " . $message->getStatus() . "\n";
            }

            return response()->json($existingUser);
        } else {
            // Se l'utente non esiste, crea un nuovo utente
            $basic  = new \Vonage\Client\Credentials\Basic("44bc4bb2", "fYVcLeo0lMhmtjm1");
            $client = new \Vonage\Client($basic);

            $user = User::create([
                'telefono' => Hash::make($request['telefono']),
                'role' => $request['role'],
            ]);
            $user->assignRole('Professional');

            $otp = VerificationCode::create([
                'telefono' => $request['telefono'],
                'otp' => rand(10000, 99999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);

            $response = $client->sms()->send(
                new SMS($request['telefono'], 'Help4You', 'Il tuo codice di verifica è:' . $otp->otp)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                echo "The message was sent successfully\n";
            } else {
                echo "The message failed with status: " . $message->getStatus() . "\n";
            }

            return response()->json($user);
        }
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);
        $otp = VerificationCode::where('otp', '=', $request->input('otp'))
            ->where('expire_at', '>', Carbon::now());
        if (!$otp->exists()) {
            return response()->json('codice non valido');
        } else {
            return response()->json('codice validato');
            $otp->delete();
        }
    }
}
