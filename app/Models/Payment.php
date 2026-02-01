<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected function casts(): array
    {
        return [
            'stripe_data' => 'array',
        ];
    }
}
