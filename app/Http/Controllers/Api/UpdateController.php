<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function updateToProfessional(Request $request)
    {
       $request->validate([
            'name' => ['required', 'string', 'max:255', 'exists:categories'],
        ]);

        $category=request()->input('name');

        $user = User::find(JWTAuth::user()->id);
        $user->removeRole('Regular User');
        $user->assignRole('Professional');

        DB::table('users_categories')->insert(
            [
               'user_id' => Auth::id(),
               'category_id' => DB::table('categories')->where('name',  '=' , $category)->value('id'),
            ]
            );

            return response()->json($user);
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function updateToUser(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->removeRole('Professional');
        $user->assignRole('Regular User');

        return response()->json($user);
    }


    /* public function update(LoginRequest $request)
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

        $user = Auth::user()->role;
        if ($user == 'Regular User') {
            $user->role = 'Professional';
        }
        $user->assignRole('Professional');
        return response()->json(['user' => $user]);
        // return CustomResponse::setSuccessResponse("", $token);
       }*/

    /*  public function update(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|unique:professionals,email',
            'nome' => 'required',
            'cognome' => 'required',
            'password' => 'required',
            'services' => 'required',
            'password_confirmation' =>'required|same:password',
        ]);

        $user = Professional::create([
            'nome' => $request['nome'],
            'cognome' => $request['cognome'],
            'telefono' => $request['telefono'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'services' => $request['services'],
        ]);
        $user->assignRole('Professional');
       return $user;
    }    */
}
