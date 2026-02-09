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
        $request->validate(['purpose' => 'required']);

        $paymentIntent = Stripe::createPaymentIntent($article, $request->all());

        $payment = new Payment;
        $payment->guest_id = Guest::fromRequest()?->id;
        $payment->purpose = $request->purpose;
        $payment->fillFromStripePI($paymentIntent);
        $payment->save();

        return $payment;
    }

    public function get(Payment $payment, Request $request)
    {
        if ($payment->guest_id != Guest::fromRequest()?->id) {
            abort(403, "Ce paiement n'est pas associé à votre profil");
        }
        if ($request->reload) {
            $paymentIntent = Stripe::getPaymentIntent($payment->stripe_id);
            $payment->fillFromStripePI($paymentIntent)->save();
        }
        return $payment;
    }

    public function toggleCoverFees(Payment $payment, Request $request)
    {
        $originalAmount = +$payment->stripe_data['metadata']['original_amount'];
        if ($request->coverFees) {
            $newAmount = ($originalAmount + 0.30) / (1 - 0.024);
        } else {
            $newAmount = $originalAmount;
        }
        $paymentIntent = Stripe::updateAmount($payment->stripe_id, $newAmount);
        $payment->fillFromStripePI($paymentIntent)->save();
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
        $payment->fillFromStripePI($paymentIntent)->save();
        PaymentUpdated::dispatch($payment);
    }
}
