<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DailySummaryNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendDailySummaryNotifications implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        User::role(['Manager', 'Admin', 'Super Admin'])
            ->where('is_active', true)
            ->get()
            ->each->notify(new DailySummaryNotification());
    }
}
