<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stripe\PaymentIntent;

class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'stripe_data' => 'array',
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $oldStatus = $payment->getOriginal('stripe_status');
            $newStatus = $payment->stripe_status;
            if ($oldStatus !== $newStatus && $newStatus === "succeeded") {
                if ($payment->purpose === 'buy-tokens') {
                    /** @var Guest $guest */
                    $guest = $payment->guest;
                    $guest->addTokens($payment);
                }
            }
        });
    }

    public function updateFromStripe(PaymentIntent $paymentIntent)
    {
        $this->stripe_data = $paymentIntent->toArray();
        $this->stripe_status = $paymentIntent->status;
        $this->save();
    }
}
