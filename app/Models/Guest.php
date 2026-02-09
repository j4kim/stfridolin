<?php

namespace App\Models;

use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Resources\Payments\PaymentResource;
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

    protected static function booted(): void
    {
        static::updated(function (Guest $guest) {
            Cache::forget("guest-$guest->id");
        });
    }

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    public function registrationMovements(): HasMany
    {
        return $this->movements()->where('type', 'registration');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
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
            'article_id' => $article->id,
            'type' => 'buy-tokens',
            'amount' => $payment->amount,
            'meta' => [
                'tokens' => $tokens,
                'balance' => $this->tokens,
                'description' => "Paiement pour " . $article->description,
                ...$metadata,
            ]
        ]);
    }

    public function register(Payment $payment)
    {
        $metadata = $payment->stripe_data['metadata'];
        $article = Article::findOrFail($metadata['article_id']);
        $this->tokens += 20;
        $this->save();
        $this->movements()->create([
            'payment_id' => $payment->id,
            'article_id' => $article->id,
            'type' => 'registration',
            'amount' => $article->price,
            'meta' => [
                'balance' => $this->tokens,
            ]
        ]);
    }

    public function spendTokens(string $articleName): Movement
    {
        $article = Article::where('name', $articleName)->firstOrFail();
        $tokens = $article->price;
        $this->tokens = $this->tokens - $article->price;
        $this->save();
        return $this->movements()->create([
            'article_id' => $article->id,
            'type' => 'spend-tokens',
            'amount' => $tokens,
            'meta' => [
                'balance' => $this->tokens,
                'description' => $articleName,
            ]
        ]);
    }

    public function broadcastOn(string $event): array
    {
        return [
            new Channel("guest-$this->id"),
        ];
    }

    public function movementsUrl(): string
    {
        return MovementResource::getUrl('index', [
            'filters' => ['guest' => ['value' => $this->id]]
        ]);
    }

    public function paymentsUrl(): string
    {
        return PaymentResource::getUrl('index', [
            'filters' => ['guest' => ['value' => $this->id]]
        ]);
    }
}
