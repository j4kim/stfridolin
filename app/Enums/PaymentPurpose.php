<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentPurpose: string implements HasLabel, HasColor
{
    case Registration = 'registration';
    case BuyTokens = 'buy-tokens';
    case Donation = 'donation';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Registration => Color::Lime,
            self::BuyTokens => Color::Sky,
            default => Color::Slate,
        };
    }
}
