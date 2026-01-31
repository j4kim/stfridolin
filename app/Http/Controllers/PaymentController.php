<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function createIntent(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SK'));

        $intent = $stripe->paymentIntents->create([
            'amount' => $request->amount * 100,
            'currency' => 'chf',
            'metadata' => [
                'guest_id' => Guest::fromRequest()->id,
                'purpose' => 'tokens',
            ],
        ]);

        return $intent;
    }
}
