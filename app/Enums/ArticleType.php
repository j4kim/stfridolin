<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum ArticleType: string implements HasLabel, HasColor
{
    case Registration = 'registration';
    case Participation = 'participation';
    case TokensPackage = 'tokens-package';
    case PointsCredit = 'points-credit';

    public function getLabel(): string | Htmlable | null
    {
        return ucfirst(__($this->value));
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Registration => Color::Lime,
            self::Participation => Color::Cyan,
            self::TokensPackage => Color::Emerald,
            self::PointsCredit => Color::Purple,
            default => Color::Slate,
        };
    }
}
