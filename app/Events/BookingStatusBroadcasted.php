<?php

namespace App\Events;

use App\Models\ServiceBooking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingStatusBroadcasted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ServiceBooking $booking)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('booking.' . $this->booking->id);
    }

    public function broadcastWith(): array
    {
        return [
            'status' => $this->booking->status,
        ];
    }
}
