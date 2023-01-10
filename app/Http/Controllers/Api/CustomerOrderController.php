<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        return $order;
    }

    public function update(Request $request,)
    {
        $request->validate([
            'order' => 'required',
        ]);
$customerOrder= new CustomerOrder;
        $customerOrder->order = request()->input('order');
        $customerOrder->save();
        return $customerOrder;
    }

    public function delete(CustomerOrder $customerOrder)
    {
        $customerOrder->delete();
    }
}
