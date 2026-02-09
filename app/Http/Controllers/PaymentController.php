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

        $payment = Payment::create([
            'guest_id' => Guest::fromRequest()?->id,
            'stripe_id' => $paymentIntent->id,
            'stripe_data' => $paymentIntent->toArray(),
            'purpose' => $request->purpose,
            'amount' => $paymentIntent->amount / 100,
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

    public function toggleCoverFees(Payment $payment, Request $request)
    {
        $article = Article::findOrFail($payment->stripe_data['metadata']['article_id']);
        if ($request->coverFees) {
            $newPrice = ($article->price + 0.30) / (1 - 0.024);
        } else {
            $newPrice = $article->price;
        }
        $paymentIntent = Stripe::updateAmount($payment->stripe_id, $newPrice);
        $payment->updateFromStripe($paymentIntent);
        PaymentUpdated::dispatch($payment);
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
