<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum OccurrenceStatus: string implements HasLabel, HasColor
{
    case Initial = 'initial';
    case Open = 'open';
    case Started = 'started';
    case Ranked = 'ranked';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Open => Color::Green,
            self::Started => Color::Gray,
            self::Ranked => Color::Cyan,
            default => Color::Slate,
        };
    }
}
