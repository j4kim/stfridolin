<?php

namespace App\Models;

use App\Enums\ArticleType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherFactory> */
    use HasFactory;
    use HasUlids;

    protected $appends = ['url'];

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
        $meta = ['voucher_id' => $this->id];
        if ($this->article->type === ArticleType::TokensPackage) {
            $guest->addTokens($this->article, null, $meta);
        } else if ($this->article->type === ArticleType::PointsCredit) {
            $guest->receivePoints($this->article, $meta);
        } else {
            abort(400, "Type d'article non pris en compte: " . $this->article->type->getLabel());
        }
        $this->save();
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn() => route('vue-app', "voucher/$this->id"),
        );
    }
}
