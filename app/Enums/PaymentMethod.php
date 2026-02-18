<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentMethod: string implements HasLabel
{
    case Twint = 'twint';
    case Stripe = 'stripe';
    case Bank = 'bank';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }
}
