<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GuestType: string implements HasLabel, HasColor
{
    case Guest = 'guest';
    case VIP = 'vip';
    case Volunteer = 'volunteer';
    case Patron = 'patron';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Guest => Color::Lime,
            self::VIP => Color::Cyan,
            self::Volunteer => Color::Emerald,
            default => Color::Slate,
        };
    }
}
