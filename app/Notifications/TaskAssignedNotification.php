<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New task assigned: '.$this->task->title)
            ->line('A new task has been assigned to you.')
            ->action('View task', route('tasks.show', $this->task));
    }

    public function toArray(object $notifiable): array
    {
        return ['task_id' => $this->task->id, 'title' => $this->task->title, 'type' => 'task_assigned'];
    }
}
