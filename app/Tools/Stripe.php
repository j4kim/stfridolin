<?php

namespace App\Tools;

use App\Models\Guest;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class Stripe
{
    public static function createPaymentIntent(int $amount, string $purpose): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));

        return $stripe->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => 'chf',
            'metadata' => [
                'guest_id' => Guest::fromRequest()->id,
                'purpose' => $purpose,
                'amount' => $amount,
            ],
        ]);
    }
}
