<?php

namespace App\Http\Controllers;

use App\Events\PaymentUpdated;
use App\Models\Article;
use App\Models\Guest;
use App\Models\Payment;
use App\Tools\Stripe;
use Illuminate\Http\Request;
use Stripe\Event;

class PaymentController extends Controller
{
    public function store(Article $article, Request $request)
    {
        $paymentIntent = Stripe::createPaymentIntent($article, $request->purpose);

        $payment = Payment::create([
            'guest_id' => Guest::fromRequest()?->id,
            'stripe_id' => $paymentIntent->id,
            'stripe_data' => $paymentIntent->toArray(),
            'purpose' => $request->purpose,
            'amount' => $article->price,
        ]);

        return $payment;
    }

    public function get(Payment $payment, Request $request)
    {
        if ($payment->guest_id != Guest::fromRequest()?->id) {
            abort(403, "Ce paiement n'est pas associé à votre profil");
        }
        if ($request->reload) {
            $paymentIntent = Stripe::getPaymentIntent($payment->stripe_id);
            $payment->updateFromStripe($paymentIntent);
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
        $payment->updateFromStripe($paymentIntent);
        PaymentUpdated::dispatch($payment);
    }
}
