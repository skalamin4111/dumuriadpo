<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Task $task, private readonly int $daysOverdue)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task overdue: '.$this->task->title)
            ->line("This task is {$this->daysOverdue} day(s) overdue.")
            ->action('Review task', route('tasks.show', $this->task));
    }

    public function toArray(object $notifiable): array
    {
        return ['task_id' => $this->task->id, 'days_overdue' => $this->daysOverdue, 'type' => 'task_overdue'];
    }
}
