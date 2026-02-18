<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stripe\PaymentIntent;

class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'stripe_data' => 'array',
            'amount' => 'float',
            'purpose' => PaymentPurpose::class,
            'status' => PaymentStatus::class,
            'method' => PaymentMethod::class,
        ];
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    protected static function booted(): void
    {
        static::saved(function (Payment $payment) {
            $oldStatus = $payment->getOriginal('status');
            $newStatus = $payment->status;
            if ($oldStatus !== $newStatus && $newStatus === PaymentStatus::succeeded) {
                if ($payment->purpose === PaymentPurpose::BuyTokens) {
                    /** @var Guest $guest */
                    $guest = $payment->guest;
                    $guest->addTokensFromPayment($payment);
                } else if ($payment->purpose === PaymentPurpose::Registration) {
                    $guestIds = str($payment->stripe_data['metadata']['guestIds'])->explode(';');
                    $guests = Guest::whereIn('id', $guestIds)->get();
                    $guests->each(fn(Guest $guest) => $guest->register($payment));
                }
            }
        });
    }

    public function fillFromStripePI(PaymentIntent $paymentIntent): Payment
    {
        $this->stripe_id = $paymentIntent->id;
        $this->stripe_data = collect($paymentIntent->toArray())->only([
            'created',
            'metadata',
            'description',
            'client_secret',
            'payment_method',
            'amount_received',
            'last_payment_error',
        ])->toArray();
        $this->status = $paymentIntent->status;
        $this->amount = $paymentIntent->amount / 100;
        return $this;
    }
}
