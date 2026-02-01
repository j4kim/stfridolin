<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $stripe = new StripeClient(config('services.stripe.sk'));

        $intent = $stripe->paymentIntents->create([
            'amount' => $request->chf * 100,
            'currency' => 'chf',
            'metadata' => [
                'guest_id' => Guest::fromRequest()->id,
                'purpose' => 'tokens',
                'tokens' => $request->tokens,
                'chf' => $request->chf,
            ],
        ]);

        $payment = Payment::create([
            'guest_id' => Guest::fromRequest()->id,
            'stripe_id' => $intent->id,
            'stripe_data' => $intent->toArray(),
            'purpose' => 'tokens',
            'amount' => $request->chf,
        ]);

        return $payment;
    }

    public function get(Payment $payment)
    {
        return $payment;
    }

    public function stripeCallback(Request $request)
    {
        return $request->all();
    }
}
