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

class EditDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

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
        return $user;
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
            'user_id' => Auth::user()->id,
            'otp' => rand(10000, 99999),
            'expired_at' => Carbon::now()->addMinutes(10)
        ]);

        $response = $client->sms()->send(
            new SMS($telefono, 'Help4You', 'A text message sent using the Nexmo SMS API' . $otp->otp)
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
        
       

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
            return $user;
        }
    }
}






 /*   $text = new OTPNotification('',$otp->otp);
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("3382496345" ,$user, 'Your verification code is' . $otp->otp)

        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
            }*/

        // return $otp;
        //  $message = Notification::route('', $user->telefono)->notify(new OTPNotification($user->telefono));
        //  return  $message ;
        //  Notification::send($user, new OTPNotification($otp->otp));
        /* $notification = new OTPNotification($otp);
        $message = $user->notify($notification);
        return $message;*/
        // $user->telefono = Hash::make(request()->input('telefono'));
