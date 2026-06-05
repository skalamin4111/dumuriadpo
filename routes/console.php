<?php

use App\Jobs\ProcessOverdueTasks;
use App\Jobs\SendDailySummaryNotifications;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new ProcessOverdueTasks())
    ->hourly()
    ->name('tasks.mark-overdue')
    ->withoutOverlapping();

Schedule::job(new SendDailySummaryNotifications())
    ->dailyAt('18:00')
    ->name('notifications.daily-summary')
    ->withoutOverlapping();
