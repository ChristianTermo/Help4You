<?php

namespace App\Http\Controllers\Api;

use Exception;
use Stripe\Charge;
use Stripe\Refund;
use Stripe\Stripe;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use App\Models\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PayPal\Api\Refund as ApiRefund;
use App\Http\Controllers\Controller;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Payment as PaypalPayment;


class PaymentController extends Controller
{
    private $_api_context;
    
    public function __construct()
    {            
        $paypal_configuration = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }
    
    public function stripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            "amount" => $request->amount * 10,
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => $request->description,
        ]);

        $payment = Payment::create([
            'amount' => $request->amount,
            'date' => Carbon::now()->format('Y-m-d-H-i-s'),
            'description' => $request->description,
            'charge_id' => $charge->id
        ]);

        return response()->json($charge);
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

        return response()->json($payer);
    }

    public function getTransactions()
    {
        $payments = Payment::all();

        $data = [
            'payments' => $payments
        ];

        return view('transactions', $data);
    }

    public function reverseTransactions($id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $transaction = Payment::find($id);

        $refund = Refund::create(
            [
                'charge' => $transaction->charge_id,
                'amount' => $transaction->amount,
                'reason' => 'duplicate'
            ]
        );

        $transaction->delete();
        return 'transaction refunded successfully';
    }
}
