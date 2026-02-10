<?php

namespace App\Models;

use App\Enums\ArticleType;
use App\Enums\Currency;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'std_price' => 'float',
            'price' => 'float',
            'type' => ArticleType::class,
            'currency' => Currency::class,
        ];
    }
}
