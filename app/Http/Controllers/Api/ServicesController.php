<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\Proposal;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ServicesController extends Controller
{
    public function getGeocode(Geocoder $geocoder)
    {
        $geocoder->geocode('Los Angeles, CA')->get();
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

        $service = Service::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => Auth::user()->id,
            'starting_point' => $request['starting_point'],
            'category' => $request['category'],
            'coverage_range' => $request['coverage_range'],
            'price' => $request['price'],
        ]);

        return $service;
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

        $service = Service::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'user_id' => Auth::user()->id,
            'starting_point' => $request['starting_point'],
            'category' => $request['category'],
            'coverage_range' => $request['coverage_range'],
            'price' => $request['price'],
        ]);

        return $service;
    }

    public function delete(Service $service, $id)
    {
        $service = Service::find($id);
        $service->delete();
    }

    public function getServices()
    {
        $services = Service::where('user_id', '=', Auth::user()->id)->get();
        return response()->json($services);
    }

    public function makeProposal(Request $request, $id)
    {
          $request->validate([
            'price' => 'required',
            'description' => 'required',
            'delivery_time' => 'required',
        ]);

        $to_user = CustomerOrder::find($id);

        $proposal = Proposal::create([
            'price' => $request['price'],
            'description' => $request['description'],
            'delivery_time' => $request['delivery_time'],
            'from_user' => Auth::user()->id,
            'to_user' => $to_user->user_id,
            'id_order' => $id,
        ]);

        return $proposal;
    }
}
