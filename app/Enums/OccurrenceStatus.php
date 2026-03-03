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
    case Finished = 'finished';
    case Ranked = 'ranked';
    case Cancelled = 'cancelled';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Open => Color::Green,
            self::Started => Color::Yellow,
            self::Ranked => Color::Cyan,
            default => Color::Slate,
        };
    }

    public function isClosed(): bool
    {
        return in_array($this, [self::Finished, self::Cancelled, self::Ranked]);
    }
}
