<?php

namespace App\Services;

use App\Actions\Tasks\CreateTaskAction;
use App\Actions\Tasks\UpdateTaskStatusAction;
use App\DTOs\TaskData;
use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $tasks,
        private readonly CreateTaskAction $createTask,
        private readonly UpdateTaskStatusAction $updateTaskStatus,
    )
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->tasks->paginate($filters);
    }

    public function create(array $data): Task
    {
        return $this->createTask->execute(TaskData::fromArray($data));
    }

    public function update(Task $task, array $data): Task
    {
        return $this->updateTaskStatus->execute($task, $data);
    }
}
