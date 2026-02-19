<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentPurpose;
use App\Enums\PaymentStatus;
use App\Tools\Stripe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Stripe\PaymentIntent;

class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'stripe_data' => 'array',
            'meta' => 'array',
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

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    protected static function booted(): void
    {
        static::created(function (Payment $payment) {
            if ($payment->method !== PaymentMethod::Stripe) {
                return;
            }
            $paymentIntent = Stripe::createPaymentIntent($payment);
            $payment->fillFromStripePI($paymentIntent);
            $payment->save();
        });

        static::saved(function (Payment $payment) {
            if ($payment->method !== PaymentMethod::Stripe) {
                return;
            }
            $oldStatus = $payment->getOriginal('status');
            $newStatus = $payment->status;
            if ($oldStatus !== $newStatus && $newStatus === PaymentStatus::succeeded) {
                $payment->handleSuccess();
            }
        });
    }

    public function fillFromStripePI(PaymentIntent $paymentIntent): Payment
    {
        $this->stripe_id = $paymentIntent->id;
        $this->stripe_data = collect($paymentIntent->toArray())->only([
            'created',
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

    public function registerGuests(): Collection
    {
        $guestIds = str($this->meta['guestIds'])->explode(';');
        $guests = Guest::whereIn('id', $guestIds)->get();
        return $guests->map(fn(Guest $guest) => $guest->register($this));
    }

    public function handleSuccess()
    {
        if ($this->purpose === PaymentPurpose::BuyTokens) {
            $this->guest->addTokensFromPayment($this);
        } else if ($this->purpose === PaymentPurpose::Registration) {
            $this->registerGuests();
        }
    }
}
