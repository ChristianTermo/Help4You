<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    
    public function __invoke(Request $request)
    {
        
        auth()->logout();
        return response()->json('logout succeded');
       // return CustomResponse::setSuccessResponse(Lang::get('auth.logout'), Response::HTTP_OK, null, null);
    }
    
}
