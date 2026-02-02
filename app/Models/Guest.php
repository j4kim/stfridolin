<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\GuestFactory> */
    use HasFactory;
    use BroadcastsEvents;

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class, 'proposed_by');
    }

    public static function cached($id): ?Guest
    {
        return Cache::remember("guest-$id", 60 * 10, fn() => Guest::find($id));
    }

    public static function fromRequest(): ?Guest
    {
        $id = request()->header('X-Guest-Id');
        if (!$id) return null;
        return self::cached($id);
    }

    public function addTokens(Payment $payment)
    {
        $metadata = $payment->stripe_data['metadata'];
        $article = Article::findOrFail($metadata['article_id']);
        $tokens = $article->meta['tokens'];
        $this->tokens += $tokens;
        $this->save();
        $this->movements()->create([
            'payment_id' => $payment->id,
            'type' => 'tokens',
            'amount' => $tokens,
            'meta' => [
                'balance' => $this->tokens,
                'description' => "Paiement pour " . $article->description,
                ...$metadata,
            ]
        ]);
    }

    public function broadcastOn(string $event): array
    {
        return [
            new Channel("guest-$this->id"),
        ];
    }
}
