<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use phpDocumentor\Reflection\Types\Void_;

class WordDiscovered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $word;
    
    /**
     * Create a new event instance.
     *
     * @param string $word
     */
    public function __construct(string $word)
    {
        $this->word = $word;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
