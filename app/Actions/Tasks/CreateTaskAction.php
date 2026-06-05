<?php

namespace App\Actions\Tasks;

use App\DTOs\TaskData;
use App\Events\TaskAssigned;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    public function __construct(private readonly TaskRepositoryInterface $tasks)
    {
    }

    public function execute(TaskData $taskData): Task
    {
        return DB::transaction(function () use ($taskData) {
            $payload = array_filter($taskData->toArray(), fn ($value) => $value !== null);
            $payload['created_by'] = Auth::id();
            $payload['status'] = $taskData->assignedEmployeeId ? 'assigned' : ($payload['status'] ?? 'new');
            $payload['sla_due_at'] = $taskData->deadlineAt;

            $task = $this->tasks->create($payload);

            foreach ($taskData->checklist ?? [] as $item) {
                $task->checklist()->create(['title' => $item]);
            }

            if ($task->assigned_employee_id) {
                TaskAssigned::dispatch($task);
            }

            return $task->refresh()->load(['assignee.user', 'customer', 'department', 'checklist']);
        });
    }
}
