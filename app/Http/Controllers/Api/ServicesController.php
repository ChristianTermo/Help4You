<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;

class ServicesController extends Controller
{
    public function getGeocode(Geocoder $geocoder)
    {
       $geocoder->geocode('Los Angeles, CA')->get();
        return response()->json($geocoder);
    }

    public function create(Request $request)
    {
        /*$ip = $request->ip();
        $currentUserInfo = Location::get($ip);
        $starting_point = $currentUserInfo->countryCode;*/

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'starting_point'  => 'required',
            'category' => 'required|',
            'coverage_range' => 'required',
            'price' => 'required',
        ]);

        $order = Service::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => Auth::user()->id,
            'starting_point' => $request['starting_point'],
            'category' => $request['category'],
            'coverage_range' => $request['coverage_range'],
            'price' => $request['price'],
        ]);

        return $order;
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'starting_point'  => 'required',
            'category' => 'required|exists:categories',
            'coverage_range' => 'required',
            'price' => 'required',
        ]);

        $service = Service::find($id);

        $service->title = $request['title'];
        $service->description = $request['description'];
        $service->starting_point = $request['starting_point'];
        $service->category = $request['category'];
        $service->coverage_range = $request['coverage_range'];
        $service->price = $request['price'];

        return $service;
    }

    public function delete(Service $service, $id)
    {
        $service = Service::find($id);
        $service->delete();
    }
}
