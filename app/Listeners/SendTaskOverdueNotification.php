<?php

namespace App\Listeners;

use App\Events\TaskOverdue;
use App\Models\User;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskOverdueNotification implements ShouldQueue
{
    public function handle(TaskOverdue $event): void
    {
        $event->task->assignee?->user?->notify(new TaskOverdueNotification($event->task, $event->daysOverdue));

        if ($event->daysOverdue >= 3) {
            User::role(['Manager', 'Supervisor'])->get()->each->notify(new TaskOverdueNotification($event->task, $event->daysOverdue));
        }

        if ($event->daysOverdue >= 7) {
            User::role(['Admin', 'Super Admin'])->get()->each->notify(new TaskOverdueNotification($event->task, $event->daysOverdue));
        }
    }
}
