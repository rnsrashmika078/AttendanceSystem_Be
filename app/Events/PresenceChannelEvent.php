<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Reverb\Protocols\Pusher\Channels\PresenceChannel as ChannelsPresenceChannel;

class PresenceChannelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */


    public $message;
    public $user;
    public $sessionId;

    public function __construct($message, $sessionId, $user = null)
    {
        $this->message = $message;
        $this->sessionId = $sessionId;
        $this->user = $user;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('presence-channel.session.' . $this->sessionId),
        ];
    }
    public function broadcastAs(): string
    {
        return 'PresenceChannelEvent';
    }
}
