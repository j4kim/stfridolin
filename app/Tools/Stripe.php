<?php

namespace App\Tools;

use App\Models\Article;
use App\Models\Guest;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class Stripe
{
    public static function createPaymentIntent(Article $article, array $metadata = []): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));

        return $stripe->paymentIntents->create([
            'amount' => $article->price * 100,
            'currency' => 'chf',
            'metadata' => [
                'guest_id' => Guest::fromRequest()?->id,
                'article_id' => $article->id,
                'article_description' => $article->description,
                ...$metadata
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
}
