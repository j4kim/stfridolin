<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum PaymentStatus: string implements HasLabel, HasColor
{
    case requires_payment_method = 'requires_payment_method';
    case requires_confirmation = 'requires_confirmation';
    case requires_action = 'requires_action';
    case processing = 'processing';
    case requires_capture = 'requires_capture';
    case canceled = 'canceled';
    case succeeded = 'succeeded';

    public function getLabel(): string | Htmlable | null
    {
        return __($this->value);
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::succeeded => Color::Green,
            self::requires_payment_method => Color::Orange,
            default => Color::Slate,
        };
    }
}
