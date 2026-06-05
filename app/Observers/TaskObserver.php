<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    public function saving(Task $task): void
    {
        if ($task->deadline_at && ! $task->sla_due_at) {
            $task->sla_due_at = $task->deadline_at;
        }
    }
}
