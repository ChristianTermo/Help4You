<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Zorb\Promocodes\Facades\Promocodes;

class CouponController extends Controller
{
    public function generate(Request $request)
    {
        Promocodes::mask('AA-***-BB') // default: config('promocodes.code_mask')
        ->characters('ABCDE12345') // default: config('promocodes.allowed_symbols') // default: false
        ->count(40) // default: 1
        ->usages(1) // default: 1
        ->expiration(now()->addDay()) // default: null
        ->details([ 'discount' => 50 ]) // default: []
        ->create();
        return response()->json("coupons created successfully");
    }

    
}
