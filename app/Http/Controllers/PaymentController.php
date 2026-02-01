<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use App\Tools\Stripe;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $paymentIntent = Stripe::createPaymentIntent($request->amount, $request->purpose, $request->tokens);

        $payment = Payment::create([
            'guest_id' => Guest::fromRequest()->id,
            'stripe_id' => $paymentIntent->id,
            'stripe_data' => $paymentIntent->toArray(),
            'purpose' => $request->purpose,
            'amount' => $request->amount,
        ]);

        return $payment;
    }

    public function get(Payment $payment)
    {
        return $payment;
    }

    public function stripeCallback(Request $request)
    {
        $paymentIntent = Stripe::getPaymentIntent($request->payment_intent);
        $payment = Payment::firstWhere('stripe_id', $paymentIntent->id);
        $payment->stripe_data = $paymentIntent->toArray();
        $payment->save();
        return redirect()->route('vue-app', "payment/$payment->id/status");
    }
}
