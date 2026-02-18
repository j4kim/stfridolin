<?php

namespace App\Tools;

use App\Models\Guest;
use App\Models\Payment;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class Stripe
{
    public static function createPaymentIntent(Payment $payment): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));

        $guest = $payment->guest;
        $guest->ensureStripeCustomer();

        return $stripe->paymentIntents->create([
            'amount' => $payment->amount * 100,
            'currency' => 'chf',
            'description' => $payment->description,
            'statement_descriptor_suffix' => str($payment->description)->slug()->substr(0, 22),
            'customer' => $guest->stripe_customer_id,
            'metadata' => [
                'payment_id' => $payment->id,
            ],
        ]);
    }

    public static function getPaymentIntent(string $paymentId): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));
        return $stripe->paymentIntents->retrieve($paymentId, []);
    }

    public static function updateAmount(string $paymentIntentId, float $newAmount): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));
        return $stripe->paymentIntents->update(
            $paymentIntentId,
            ['amount' => (int) ($newAmount * 100)]
        );
    }

    public static function createCustomer(Guest $guest): Customer
    {
        $stripe = new StripeClient(config('services.stripe.sk'));
        return $stripe->customers->create([
            'name' => $guest->name,
            'description' => $guest->key,
        ]);
    }
}
