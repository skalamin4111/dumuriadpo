<?php

namespace App\Services;

use App\Events\TaskOverdue;
use App\Models\Task;

class OverdueTaskService
{
    public function process(): int
    {
        $tasks = Task::query()
            ->with('assignee.user')
            ->where('deadline_at', '<', now())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->get();

        foreach ($tasks as $task) {
            if ($task->status !== 'overdue') {
                $task->update(['status' => 'overdue']);
            }

            TaskOverdue::dispatch($task, (int) now()->diffInDays($task->deadline_at));
        }

        return $tasks->count();
    }
}
