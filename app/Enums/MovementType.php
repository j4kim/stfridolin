<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum MovementType: string implements HasLabel, HasColor
{
    case Registration = 'registration';
    case BuyTokens = 'buy-tokens';
    case SpendTokens = 'spend-tokens';
    case Manual = 'manual';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Registration => Color::Green,
            self::BuyTokens => Color::Indigo,
            self::SpendTokens => Color::Rose,
            default => Color::Slate,
        };
    }
}
