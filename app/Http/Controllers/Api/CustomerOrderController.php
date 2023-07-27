<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'description' => 'required',
            'category' => 'required',
            'scadenza' => 'required',
            'budget_min' => 'required',
            'budget_max' => 'required',
            'attachments'
        ]);

        $order = CustomerOrder::create([
            'order' => $request['order'],
            'user_id' => JWTAuth::user()->id,
            'description' => $request['description'],
            'category' => $request['category'],
            'scadenza' => $request['scadenza'],
            'budget_min' => $request['budget_min'],
            'budget_max' => $request['budget_max'],
            'attachments' => $request['attachments']
        ]);
        return response()->json($order);;
    }

    public function update(Request $request, $id)
    {
        $customerOrder = CustomerOrder::find($id);
        $customerOrder->order = request()->input('order');
        $customerOrder->description = request()->input('description');
        $customerOrder->category = request()->input('category');
        $customerOrder->scadenza =  request()->input('scadenza');
        $customerOrder->budget_min =   request()->input('budget_min');
        $customerOrder->budget_max =   request()->input('budget_max');
        $customerOrder->attachments = request()->input('attachments');
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
        $customerOrder = CustomerOrder::where('user_id', '=', Auth::user()->id)->get();
        return response()->json($customerOrder);
    }

    public function getProposals()
    {
        $proposals = DB::table('proposals')
            ->where('to_user', '=', Auth::user()->id)
            ->where('is_accepted', '=', null)
            ->get();

        return $proposals;
    }

    public function acceptProposal(Request $request, $id)
    {
        $request->validate([
            'accepted' => ['required'],
        ]);

        $accepted = $request['accepted'];

        if ($accepted == true) {
            DB::table('proposals')
                ->where('id', $id)
                ->update(
                    [
                        'is_accepted' => true,
                    ]
                );
        } else {
            DB::table('proposals')
                ->where('id', $id)
                ->delete();
        }

        return response()->json('proposal updated');
    }
}
