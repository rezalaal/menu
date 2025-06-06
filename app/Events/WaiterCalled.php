<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WaiterCalled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tableId;
    /**
     * Create a new event instance.
     */
    public function __construct($tableId)
    {
        $this->tableId = $tableId;
    }

    public function broadcastOn()
    {
        return new Channel('waiter-channel');
    }

    public function broadcastAs()
    {
        return 'waiter-called';
    }
}
