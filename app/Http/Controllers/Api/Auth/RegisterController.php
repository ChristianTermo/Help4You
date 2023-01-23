<?php

namespace App\Http\Controllers\Api\Auth;


use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\support\Facades\Hash;
use App\Models\User;
use PhpParser\Node\Expr\Cast\String_;
use Spatie\Permission\Traits\HasRoles;

class RegisterController extends Controller
{
    public function action(RegisterRequest $request, User $user)
    {
        $user = User::create([
            'nome' => $request['nome'],
            'cognome' => $request['cognome'],
            'telefono' => Hash::make($request['telefono']),
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole('Regular User');
        //  dd($user);
        /* if($user!=null){
            event(new UserRegisteredEvent($user));
       };*/
        return response()->json($user);
    }
}
