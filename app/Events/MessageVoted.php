<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageVoted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $forumId,
        public int $messageId,
        public array $options,
        public int $totalVotes
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('forum.' . $this->forumId)];
    }

    public function broadcastWith(): array
    {
        return [
            'message_id' => $this->messageId,
            'options' => $this->options,
            'total_votes' => $this->totalVotes,
        ];
    }
}
