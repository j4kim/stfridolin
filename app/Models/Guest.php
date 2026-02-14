<?php

namespace App\Models;

use App\Enums\MovementType;
use App\Enums\PaymentStatus;
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

    public function succeededPayments(): HasMany
    {
        return $this->payments()->where('stripe_status', PaymentStatus::succeeded);
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

    public function createMovement(array $data): Movement
    {
        $movement = $this->movements()->create($data);
        $this->recomputeTokensAndPoints()->save();
        return $movement;
    }

    public function addTokens(Article $article, ?int $paymentId = null): Movement
    {
        return $this->createMovement([
            'payment_id' => $paymentId,
            'article_id' => $article->id,
            'type' => MovementType::BuyTokens,
            'chf' => -$article->price,
            'tokens' => $article->meta['tokens'],
        ]);
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
        return $this->createMovement([
            'payment_id' => $payment->id,
            'article_id' => $article->id,
            'type' => MovementType::Registration,
            'chf' => -$article->price,
            'tokens' => 20,
        ]);
    }

    public function spendTokens(string $articleName): Movement
    {
        $article = Article::where('name', $articleName)->firstOrFail();
        return $this->createMovement([
            'article_id' => $article->id,
            'type' => MovementType::SpendTokens,
            'tokens' => -$article->price,
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

    protected function authUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => route('vue-app', "guest/$this->key"),
        );
    }

    public function createStripeCustomer(): Guest
    {
        $customer = Stripe::createCustomer($this);
        $this->stripe_customer_id = $customer->id;
        return $this;
    }

    public static function createStripeCustomerAndGuest(string $name): Guest
    {
        $guest = new Guest;
        $guest->name = $name;
        $guest->key = str()->random(4);
        $guest->createStripeCustomer();
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
