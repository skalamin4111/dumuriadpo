<?php

namespace App\Actions\Tasks;

use App\Events\TaskStatusChanged;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UpdateTaskStatusAction
{
    public function __construct(private readonly TaskRepositoryInterface $tasks)
    {
    }

    public function execute(Task $task, array $data): Task
    {
        return DB::transaction(function () use ($task, $data) {
            $oldStatus = $task->status;

            if (($data['status'] ?? null) === 'completed') {
                $data['status'] = 'pending_review';
                $data['completed_at'] = now();
                $data['progress'] = 100;
            }

            if (($data['status'] ?? null) === 'pending_approval') {
                $data['status'] = 'pending_review';
            }

            $updated = $this->tasks->update($task, $data);

            if ($oldStatus !== $updated->status) {
                TaskStatusChanged::dispatch($updated, $oldStatus, $updated->status);
            }

            return $updated;
        });
    }
}
