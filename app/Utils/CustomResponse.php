<?php

namespace App\Utils;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
class CustomResponse
{


    public static function setFailResponse($message, $code, $errors = null)
    {
        $params = array(
            'success' => false,
            'message' => $message,
            'code' => $code,
            'errors' => $errors,
        );
        //code is the status of result request (200, 404, 500...)

        return response()->json($params, $code);
    }

    
    public static function setSuccessResponse()
    {
        $params = array(
            Auth::user()->nome,
            Auth::user()->cognome,
            Auth::user()->email,
            Auth::user()->role,          
        );
        //code is the status of result request (200, 404, 500...)

        return response()->json($params);
    }

    public static function getCategories(){

        $params = array(
           Category::all(),
           Subcategory::all(),
        );

        return response()->json($params);
    }
}
