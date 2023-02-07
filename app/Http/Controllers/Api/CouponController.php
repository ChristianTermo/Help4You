<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\batch;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'count' => 'integer',
            'code' => 'unique:coupons,code',
            'discount' => 'required',
            'expired_at' => 'date',
            'multi_use' => 'boolean',
        ]);

        $mask = 'xxXXXXXXxx';
        $findCode = 'XXXXXX';
        $findLotto = 'xx';

        $generatedLotto = $this->generateLotto();
        $lottoCode  = str_replace($findLotto, $generatedLotto, $mask);

        $count = $request->input('count') + (10/100)*$request->input('count');

        for ($i = 0; $i < $count; $i++) {
        $generatedCode= $this->generateCode();
        $code = str_replace($findCode, $generatedCode, $lottoCode);
            $coupon = Coupon::make([
                'code' => $code,
                'discount' => $request['discount'],
                'expired_at' => $request['expired_at'],
                'multi_use' => $request['multi_use'],
            ]);
        }

        foreach ($coupon as $key => $value) {
            Coupon::insert([
                'code' => $code,
                'discount' => $request['discount'],
                'expired_at' => $request['expired_at'],
                'multi_use' => $request['multi_use'],
            ]);
        }
       // return $count;
        return response()->json('coupon created successfully');
    }

    public function generateCode()
    {
        $characters = '23456ACDEFGLMNPJQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function generateLotto()
    {
        $characters = '23456ACDEFGLMNPJQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomLotto = '';
        do {
            for ($i = 0; $i < 2; $i++) {
                $randomLotto .= $characters[rand(0, $charactersLength - 1)];
                $countLotto = batch::where('lotto', '=', $randomLotto)->count();
            }
        } while ($countLotto > 1);

        if ($countLotto == 0) {
            DB::table('batches')
                ->insert([
                    'lotto' => $randomLotto
                ]);
        }

        return $randomLotto;
    }
}
