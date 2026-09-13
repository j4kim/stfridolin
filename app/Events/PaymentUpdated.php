<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Payment $payment) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("guest-{$this->payment->guest_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'PaymentUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            "payment" => [
                "id" => $this->payment->id,
                "created_at" => $this->payment->created_at,
                "updated_at" => $this->payment->updated_at,
                "guest_id" => $this->payment->guest_id,
                "stripe_id" => $this->payment->stripe_id,
                "status" => $this->payment->status,
                "stripe_data" => $this->payment->stripe_data,
                "purpose" => $this->payment->purpose,
                "amount" => $this->payment->amount,
                "method" => $this->payment->method,
                "article_id" => $this->payment->article_id,
                "description" => $this->payment->description,
                "original_amount" => $this->payment->original_amount,
                "meta" => $this->payment->meta,
                "article" => $this->payment->article,
            ]
        ];
    }
}
