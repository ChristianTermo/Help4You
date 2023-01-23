<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Stevebauman\Location\Location;

class ServicesController extends Controller
{
    public function create(Request $request)
    {
      /*$ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $starting_point = $currentUserInfo->countryCode;*/

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'starting_point'  => 'required',
            'coverage_range' => 'required',
            'price' => 'required',
        ]);

        $order = Service::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => JWTAuth::user()->id,
            'starting_point' => $request['starting_point'],
            'coverage_range' => $request['coverage_range'],
            'price' => $request['price'],
        ]);
        
        return $order;
    
    }
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'starting_point'  => 'required',
            'coverage_range' => 'required',
            'price' => 'required',
        ]);

        $order = Service::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => JWTAuth::user()->id,
            'starting_point' => $request['starting_point'],
            'coverage_range' => $request['coverage_range'],
            'price' => $request['price'],
        ]);

        return $order;
    }

    public function delete(Service $service)
    {
        $service->delete();
    }
}
