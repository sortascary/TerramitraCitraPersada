<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class DailyNotificationSummary extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public $notifications
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have unread notifications',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.daily-summary',
        );
    }
}
