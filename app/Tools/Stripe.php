<?php

namespace App\Tools;

use App\Exceptions\NoGuestException;
use App\Models\Article;
use App\Models\Guest;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class Stripe
{
    public static function createPaymentIntent(Article $article, array $metadata = []): PaymentIntent
    {
        $stripe = new StripeClient(config('services.stripe.sk'));

        $quantity = $metadata['quantity'] ?? 1;
        $description = $metadata['description'] ?? $article->description;
        $amount = $article->price * $quantity;

        $guest = Guest::fromRequest();

        if (!$guest) {
            throw new NoGuestException();
        }

        $guest->ensureStripeCustomer();

        $payload = [
            'amount' => $amount * 100,
            'currency' => 'chf',
            'description' => $description,
            'statement_descriptor_suffix' => str($description)->slug()->substr(0, 22),
            'customer' => $guest->stripe_customer_id,
            'metadata' => [
                ...$metadata,
                'guest_id' => $guest->id,
                'article_id' => $article->id,
                'original_amount' => $amount,
            ],
        ];

        return $stripe->paymentIntents->create($payload);
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
