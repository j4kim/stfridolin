<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use App\Events\PaymentUpdated;
use App\Models\Article;
use App\Models\Guest;
use App\Models\Payment;
use App\Tools\Stripe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Stripe\Event;

class PaymentController extends Controller
{
    public function store(Article $article, Request $request)
    {
        $request->validate([
            'purpose' => [Rule::enum(PaymentPurpose::class)],
            'method' => [Rule::enum(PaymentMethod::class)],
        ]);

        $input = $request->collect();

        $guest = Guest::fromRequest();
        $quantity = $input->get('quantity', 1);
        $amount = $article->price * $quantity;

        $payment = Payment::create([
            'guest_id' => $guest->id,
            'status' => PaymentStatus::Initial,
            'purpose' => $input->get('purpose'),
            'amount' => $amount,
            'original_amount' => $amount,
            'method' => $input->get('method'),
            'description' => $input->get('description', $article->description),
            'article_id' => $article->id,
            'meta' => $input->except('description', 'purpose', 'method'),
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
            $payment->fillFromStripePI($paymentIntent)->save();
        }
        return $payment;
    }

    public function toggleCoverFees(Payment $payment, Request $request)
    {
        if ($request->coverFees) {
            $newAmount = ($payment->original_amount + 0.30) / (1 - 0.024);
        } else {
            $newAmount = $payment->original_amount;
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
