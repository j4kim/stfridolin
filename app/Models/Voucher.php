<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherFactory> */
    use HasFactory;
    use HasUlids;

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function use(Guest $guest)
    {
        $this->guest_id = $guest->id;
        $guest->addTokens($this->article, null, ['voucher_id' => $this->id]);
        $this->save();
    }
}
