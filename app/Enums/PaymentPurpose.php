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

    public function getLabel(): string | Htmlable | null
    {
        return __($this->value);
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Registration => Color::Green,
            self::BuyTokens => Color::Indigo,
            default => Color::Slate,
        };
    }
}
