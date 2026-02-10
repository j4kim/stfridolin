<?php

namespace App\Models;

use App\Enums\ArticleType;
use App\Enums\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $appends = ['discount'];

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

    protected function discount(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->std_price === $this->price || $this->std_price === null) {
                    return null;
                }
                return (100 * ($this->std_price - $this->price)) / $this->std_price;
            },
        );
    }
}
