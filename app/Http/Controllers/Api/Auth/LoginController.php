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

    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email',  'password');
        try {
            if (!$token = Auth::attempt($credentials)) {
                return response()->json('credenziali errate');
                //  $errorrMSG=Lang::get('auth.credential_incorrect');
                // return CustomResponse::setFailResponse($errorrMSG, Response::HTTP_NOT_ACCEPTABLE, []);
            }
        } catch (JWTException $e) {
            return response()->json('login fallito');
        }
       return $token;
       // return CustomResponse::setSuccessResponse($token, '') . $token;
    }

    public function loginByGoogle(Request $request)
    {

        $input = $request->input('token');

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $input);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($curl_handle));
        curl_close($curl_handle);
        if (!isset($response->email)) {
            return response()->json(['error' => 'wrong google token / this google token is already expired.'], 401);
        }

        // we get feedback from google & can use this email for creating a new user
        // then pass it to Laravel passport
        $user = User::where('email', $response->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $response->email;
            $user->email = $response->email;
            $user->password = Hash::make($response->password);
            $user->save();
        }

        //this traits PassportToken comes in handy
        //you don't need to generate token with password
        $token = $this->getBearerTokenByUser($user);
        return response()->json(['data' => $token], 200);
    }

    public function loginUsingFacebook()
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
