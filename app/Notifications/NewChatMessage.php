<?php

namespace App\Notifications;
use App\Models\MessageForum;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewChatMessage extends Notification
{
    use Queueable;

    public function __construct(public MessageForum $message) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'forum_id' => $this->message->forum_id,
            'forum_name' => $this->message->forum->name,
            'sender' => $this->message->user->name,
            'message' => strlen($this->message->message) > 50 
                ? substr($this->message->message, 0, 50) . '...' 
                : $this->message->message,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}