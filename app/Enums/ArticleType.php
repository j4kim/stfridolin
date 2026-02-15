<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ArticleType: string implements HasLabel, HasColor
{
    case Registration = 'registration';
    case Jukeboxe = 'jukeboxe';
    case TokensPackage = 'tokens-package';

    public function getLabel(): string | Htmlable | null
    {
        return __($this->value);
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Registration => Color::Green,
            self::Jukeboxe => Color::Cyan,
            self::TokensPackage => Color::Yellow,
            default => Color::Slate,
        };
    }
}
