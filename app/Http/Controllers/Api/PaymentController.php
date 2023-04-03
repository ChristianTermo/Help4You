<?php

namespace App\Http\Controllers\Api;

use Stripe\Charge;
use Stripe\Stripe;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment as PaypalPayment;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use App\Models\Payment;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function stripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        //dd($request->stripeToken);

        Charge::create([
            "amount" => $request->amount * 100,
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => $request->description,
            "card" => $request->card
        ]);

        $payment = Payment::create([
            'amount' => $request->amount,
            'date' => Carbon::now()->format('Y-m-d-H-i-s'),
            'description' => $request->description,
        ]);

        return response()->json($payment);
    }

    public function postPaymentWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('eur')
            ->setTotal($request->get($request->amount * 100));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription($request->description);

        $payment = new PaypalPayment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        $paymentObj = Payment::create([
            'amount' => $request->amount,
            'date' => Carbon::now()->format('Y-m-d-H-i-s'),
            'description' => $request->description,
        ]);

        return response()->json($paymentObj);
    }

    public function getTransactions()
    {
        $payments = Payment::all();

        $data = [
            'payments' => $payments
        ];

        return view('transactions', $data);
    }
}
