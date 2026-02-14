<?php

namespace App\Models;

use App\Enums\MovementType;
use App\Filament\Resources\Movements\MovementResource;
use App\Filament\Resources\Payments\PaymentResource;
use App\Tools\Stripe;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\GuestFactory> */
    use HasFactory;
    use BroadcastsEvents;

    protected $appends = ['auth_url'];

    protected static function booted(): void
    {
        static::updated(function (Guest $guest) {
            Cache::forget("guest-$guest->id");
        });

        static::creating(function (Guest $guest) {
            if (!$guest->key) {
                $guest->key = str()->random(4);
            }
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

    public function addTokens(Article $article, ?int $paymentId = null): Movement
    {
        $movement = $this->movements()->create([
            'payment_id' => $paymentId,
            'article_id' => $article->id,
            'type' => MovementType::BuyTokens,
            'tokens' => $article->meta['tokens'],
        ]);
        $this->recomputeTokensAndPoints()->save();
        return $movement;
    }

    public function addTokensFromPayment(Payment $payment): Movement
    {
        $metadata = $payment->stripe_data['metadata'];
        $article = Article::findOrFail($metadata['article_id']);
        return $this->addTokens($article, $payment->id);
    }

    public function register(Payment $payment): Movement
    {
        $metadata = $payment->stripe_data['metadata'];
        $article = Article::findOrFail($metadata['article_id']);
        $movement = $this->movements()->create([
            'payment_id' => $payment->id,
            'article_id' => $article->id,
            'type' => MovementType::Registration,
            'chf' => -$article->price,
            'tokens' => 20,
        ]);
        $this->recomputeTokensAndPoints()->save();
        return $movement;
    }

    public function spendTokens(string $articleName): Movement
    {
        $article = Article::where('name', $articleName)->firstOrFail();
        $movement = $this->movements()->create([
            'article_id' => $article->id,
            'type' => MovementType::SpendTokens,
            'tokens' => -$article->price,
        ]);
        $this->recomputeTokensAndPoints()->save();
        return $movement;
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

    protected function authUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => route('vue-app', "guest/$this->key"),
        );
    }

    public static function createStripeCustomerAndGuest(string $name): Guest
    {
        $guest = new Guest;
        $guest->name = $name;
        $guest->key = str()->random(4);
        $customer = Stripe::createCustomer($guest);
        $guest->stripe_customer_id = $customer->id;
        $guest->save();
        return $guest;
    }

    public function recomputeTokensAndPoints(): self
    {
        $this->tokens = $this->movements->sum('tokens');
        $this->points = $this->movements->sum('points');
        return $this;
    }
}
