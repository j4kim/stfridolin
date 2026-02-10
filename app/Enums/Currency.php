<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum Currency: string implements HasLabel, HasColor
{
    case CHF = 'CHF';
    case Tokens = 'tokens';

    public function getLabel(): string | Htmlable | null
    {
        return $this->name;
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Tokens => Color::Teal,
            default => Color::Slate,
        };
    }
}
