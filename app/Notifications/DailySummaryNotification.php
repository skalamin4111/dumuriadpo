<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailySummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $overdue = Task::where('status', 'overdue')->count();
        $pending = Task::whereIn('status', ['on_hold', 'pending_review', 'pending_approval'])->count();

        return (new MailMessage)
            ->subject('DPO ERP daily operations summary')
            ->line("Overdue tasks: {$overdue}")
            ->line("Pending review/blocked tasks: {$pending}")
            ->action('Open dashboard', route('dashboard'));
    }

    public function toArray(object $notifiable): array
    {
        return ['type' => 'daily_summary', 'generated_at' => now()->toISOString()];
    }
}
