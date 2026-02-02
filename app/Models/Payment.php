<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stripe\PaymentIntent;

class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'stripe_data' => 'array',
        ];
    }

    public function updateFromStripe(PaymentIntent $paymentIntent)
    {
        $this->stripe_data = $paymentIntent->toArray();
        $this->stripe_status = $paymentIntent->status;
        $this->save();
    }
}
