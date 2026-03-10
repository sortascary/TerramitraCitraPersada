<?php

namespace App\Events;

use App\Models\MessageForum;
use App\Http\Resources\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public function __construct(public MessageForum $message) {}

    public function broadcastOn(): array
    {
        return [new Channel('forum.' . $this->message->forum_id)];
    }

    public function broadcastWith(): array
    {
        $this->message->load('user', 'attachments', 'polloptions', 'message_reply');
        return [
            'message' => new MessageResource($this->message)
        ];
    }
}
