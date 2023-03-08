<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\batch;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function getCouponPage()
    {
        
        return view('coupon');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'count' => 'integer',
            'code' => 'unique:coupons,code',
            'discount' => 'required',
            'expired_at' => 'date',
            'multi_use' => 'boolean',
        ]);

        $mask = 'xxXXXXXXyy';
        $findCode = 'XXXXXX';
        $findLotto = 'xx';
        $findLotto2 = 'yy';

        $generatedLotto = $this->generateLotto();
        $arr1 = str_split($generatedLotto, 2);
        //return $arr1;
        $lottoCode  = str_replace($findLotto, $arr1[0], $mask);
        $lottoCode2  = str_replace($findLotto2, $arr1[1], $lottoCode);

        //return $lottoCode2;

        $count = $request->input('count') + (10/100)*$request->input('count');

        for ($i = 0; $i < $count; $i++) {
        $generatedCode= $this->generateCode();
        $code = str_replace($findCode, $generatedCode, $lottoCode2);
            $coupon[$code] = Coupon::make([
                'code' => $code,
                'discount' => $request['discount'],
                'expired_at' => $request['expired_at'],
                'multi_use' => $request['multi_use'],
            ]);        
        }
        foreach ($coupon as $key => $value) {
            $generatedCode= $this->generateCode();
            $code = str_replace($findCode, $generatedCode, $lottoCode);
            Coupon::create([               
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
            for ($i = 0; $i < 4; $i++) {
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
