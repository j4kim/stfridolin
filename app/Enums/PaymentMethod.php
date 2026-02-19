<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentMethod: string implements HasLabel, HasColor
{
    case Twint = 'twint';
    case Stripe = 'stripe';
    case Bank = 'bank';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Twint => Color::Orange,
            self::Stripe => Color::Indigo,
            default => Color::Slate,
        };
    }
}
