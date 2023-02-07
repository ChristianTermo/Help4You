<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function create(Request $request)
    {
        $request->validate([
            'order' => 'required',
        ]);

        $order = CustomerOrder::create([
            'order' => $request['order'],
            'user_id' => JWTAuth::user()->id
        ]);
        return response()->json($order);;
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order' => 'required',
        ]);
        $customerOrder = CustomerOrder::find($id);
        $customerOrder->order = request()->input('order');
        $customerOrder->save();
        return response()->json($customerOrder);
    }

    public function delete(CustomerOrder $customerOrder, $id)
    {
        $customerOrder = CustomerOrder::find($id);
        $customerOrder->delete();
    }

    public function getOrders()
    {
        $customerOrder = CustomerOrder::where('user_id', '=', Auth::user()->id);
        return response()->json($customerOrder);
    }
}
