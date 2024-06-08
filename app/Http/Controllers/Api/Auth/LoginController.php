<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Utils\CustomResponse;
use App\Http\Traits\PassportToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Util\Exception;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use PassportToken;
    
    public function login(LoginRequest $request)
    {
        // Estrai il numero di telefono dalla richiesta
        $telefono = $request->input('telefono');
    
        // Trova l'utente utilizzando il numero di telefono
        $user = User::where('telefono', $telefono)->first();
    
        // Verifica se l'utente esiste e se il campo telefono è stato trovato
        if (!$user) {
            return response()->json('Numero di telefono non valido', 404);
        }
    
        // Genera un token JWT per l'utente
        $token = Auth::login($user);
    
        if (!$token) {
            return response()->json('Autenticazione fallita', 401);
        }
    
        // Restituisci l'utente e il token JWT come risposta
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginByGoogle(Request $request)
    {
        try {
      
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if ( $finduser ) {
       
                Auth::login($finduser);
      
                return response()->json('user logged in successfully');
               // return $user;
            } else {
                $newUser = User::create([
                    'nome' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => 'dummypassword'// you can change auto generate password here and send it via email but you need to add checking that the user need to change the password for security reasons
                ]);
      
                Auth::login($newUser);
      
                return response()->json('user logged in successfully');
                //return $user;
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function facebookRedirect()
    {
       return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {
    
            $user = Socialite::driver('facebook')->user();
            $isUser = User::where('fb_id', $user->id)->first();
     
            if($isUser){
                Auth::login($isUser);
                return response()->json('login effettuato');
            }else{
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);
    
                Auth::login($createUser);
                return response()->json('login effettuato');
            }
    
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
