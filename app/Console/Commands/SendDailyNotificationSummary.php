<?php

namespace App\Console\Commands;

use App\Mail\DailyNotificationSummary;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyNotificationSummary extends Command
{
    protected $signature = 'notifications:daily-summary';
    protected $description = 'Send daily email summary of unread notifications';

    public function handle(): void
    {
        User::query()
            ->whereHas('notifications', fn ($q) => $q->whereNull('read_at'))
            ->with(['notifications' => fn ($q) => $q->whereNull('read_at')])
            ->each(function (User $user) {
                if ($user->notifications->isEmpty()) {
                    return;
                }
                Mail::to($user->email)
                    ->send(new DailyNotificationSummary($user, $user->notifications));

                $this->info("Sent to {$user->email}");
            });
    }
}
