<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class Message implements ShouldBroadcast
{
    public $senderEmail;
    public $chatId;
    public $message;
    public $recieverEmail;
    public $time;

    // Constructor that takes sender_id, recipient_id, and content
    public function __construct($senderEmail, $chatId, $message,$recieverEmail,$time)
    {
        $this->senderEmail = $senderEmail;
        $this->chatId = $chatId;
        $this->message = $message;
        $this->recieverEmail = $recieverEmail;
        $this->time = $time;

        // Log::info("📡 Broadcasting to channel", [
        //     'channel' => 'private.user.' . $chatId,
        //     'sender' => $senderEmail,
        //     'recipient' => $chatId,
        // ]);
    }
    // Broadcast on a private channel
    public function broadcastOn()
    {

        return [new Channel('private.user.' . $this->chatId)];

    }

    // Optionally, set the event name that will be sent over the WebSocket
    public function broadcastAs()
    {
        return 'message';
    }
    public function broadcastWith()
    {

        // Data to send when the event is broadcasted
        return [
            'senderEmail' => $this->senderEmail,
            'recieverEmail' => $this->recieverEmail,
            'message' => $this->message,
            'chatId' => $this->chatId,
            'time' => $this->time,
        ];
    }
}
