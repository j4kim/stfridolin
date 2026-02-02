<?php

namespace App\Http\Controllers;

use App\Events\PaymentUpdated;
use App\Models\Guest;
use App\Models\Payment;
use App\Tools\Stripe;
use Illuminate\Http\Request;
use Stripe\Event;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $paymentIntent = Stripe::createPaymentIntent($request->amount, $request->purpose, $request->tokens);

        $payment = Payment::create([
            'guest_id' => Guest::fromRequest()?->id,
            'stripe_id' => $paymentIntent->id,
            'stripe_data' => $paymentIntent->toArray(),
            'purpose' => $request->purpose,
            'amount' => $request->amount,
        ]);

        return $payment;
    }

    public function get(Payment $payment, Request $request)
    {
        if ($payment->guest_id != Guest::fromRequest()?->id) {
            abort(403, "Ce paiement n'est pas associé à votre profil");
        }
        if ($request->reload) {
            $paymentIntent = Stripe::getPaymentIntent($request->payment_intent);
            $payment->stripe_data = $paymentIntent->toArray();
            $payment->save();
        }
        return $payment;
    }

    public function stripeWebhook(Request $request)
    {
        if (!in_array($request->type, [
            'payment_intent.succeeded',
            'payment_intent.processing',
            'payment_intent.payment_failed',
        ])) {
            return;
        }
        $event = Event::constructFrom($request->all());
        $paymentIntent = $event->data->object;
        $payment = Payment::firstWhere('stripe_id', $paymentIntent->id);
        $payment->stripe_data = $paymentIntent->toArray();
        $payment->save();
        PaymentUpdated::dispatch($payment);
    }
}
