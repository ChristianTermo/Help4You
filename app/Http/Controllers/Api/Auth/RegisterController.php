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
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    public function registertest(RegisterRequest $request, User $user)
    {
        $user = User::where('telefono', $request['telefono'])->first();

        if ($user) {
            // Se l'utente esiste già, invia direttamente l'OTP
            $otp = VerificationCode::create([
                'telefono' => $request['telefono'],
                'otp' => rand(10000, 99999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);
            $telefono = $user->telefono;

            return response()->json("utente già registrato");
        } else {
            $basic  = new \Vonage\Client\Credentials\Basic("44bc4bb2", "fYVcLeo0lMhmtjm1");
            $client = new \Vonage\Client($basic);

            $user = User::create([
                'telefono' => $request['telefono'],
                'role' => 'Regular User',
            ]);
            $user->assignRole('Regular User');

            $otp = VerificationCode::create([
                'telefono' => $request['telefono'],
                'otp' => rand(10000, 99999),
                'expire_at' => Carbon::now()->addMinutes(10)
            ]);

            $telefono = $request->input('telefono');
        }
        $message = Http::get('https://www.services.europsms.com/smpp-gateway.php', [
            'op' => 'sendSMS2',
            'smpp_id' => 'christiantermo40@gmail.com',
            'utenti_password' => 'termo',
            'tipologie_sms_id' => '6',
            'destinatari_destination_addr' => $telefono,
            'trasmissioni_messaggio' => 'Il tuo codice di verifica è: ' . $otp->otp,
            'trasmissioni_mittente' => ''
        ]);



        return response()->json($user);
    }
    public function action(RegisterRequest $request)
    {
        $telefono = $request['telefono'];
        $user = User::where('telefono', $telefono)->first();

        try {
            if ($user) {
                // Se l'utente esiste già, invia direttamente l'OTP
                $otp = VerificationCode::create([
                    'telefono' => $request['telefono'],
                    'otp' => rand(10000, 99999),
                    'expire_at' => Carbon::now()->addMinutes(10)
                ]);

                // Genera il token per l'utente esistente
                $token = Auth::login($user);
            } else {
                // Crea un nuovo utente
                $user = User::create([
                    'telefono' => $telefono,
                    'role' => 'Regular User',
                ]);
                $user->assignRole('Regular User');

                $otp = VerificationCode::create([
                    'telefono' => $request['telefono'],
                    'otp' => rand(10000, 99999),
                    'expire_at' => Carbon::now()->addMinutes(10)
                ]);

                // Genera il token per il nuovo utente
                $token = Auth::login($user);
            }

            // Invia il messaggio SMS
            $response = Http::get('https://www.services.europsms.com/smpp-gateway.php', [
                'op' => 'sendSMS2',
                'smpp_id' => env('SMPP_ID'),
                'utenti_password' => env('SMPP_PASSWORD'),
                'tipologie_sms_id' => '6',
                'destinatari_destination_addr' => $telefono,
                'trasmissioni_messaggio' => 'Il tuo codice di verifica è: ' . $otp,
                'trasmissioni_mittente' => ''
            ]);

            if ($response->successful()) {
                
            } else {
                throw new \Exception('Errore durante l\'invio del messaggio SMS.');
            }

            // Restituisce la risposta JSON con l'utente e il token
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            // Log dell'errore
            Log::error('Errore durante la registrazione o l\'invio dell\'OTP: ' . $e->getMessage());

            // Restituisce una risposta di errore JSON
            return response()->json([
                'status' => 'error',
                'message' => 'Si è verificato un errore durante la registrazione o l\'invio dell\'OTP.'
            ], 500);
        }
    }

    private function generateOtp($telefono)
    {
        return VerificationCode::create([
            'telefono' => $telefono,
            'otp' => rand(10000, 99999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    private function sendSms($telefono, $otp)
    {
        $response = Http::get('https://www.services.europsms.com/smpp-gateway.php', [
            'op' => 'sendSMS2',
            'smpp_id' => env('SMPP_ID'),
            'utenti_password' => env('SMPP_PASSWORD'),
            'tipologie_sms_id' => '6',
            'destinatari_destination_addr' => $telefono,
            'trasmissioni_messaggio' => 'Il tuo codice di verifica è: ' . $otp,
            'trasmissioni_mittente' => ''
        ]);

        if ($response->successful()) {
            return $response->body();
        } else {
            throw new \Exception('Errore durante l\'invio del messaggio SMS.');
        }
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
