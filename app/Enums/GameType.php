<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum GameType: string implements HasLabel, HasColor
{
    case Race = 'race';
    case Quiz = 'quiz';
    case Jukeboxe = 'jukeboxe';
    case Fun = 'fun';
    case Guess = 'guess';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            default => Color::Slate,
        };
    }
}
