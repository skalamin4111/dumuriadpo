<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $tasks)
    {
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);

        return TaskResource::collection($this->tasks->paginate($request->query()));
    }

    public function store(TaskRequest $request)
    {
        return new TaskResource($this->tasks->create($request->validated()));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return new TaskResource($task->load(['assignee.user', 'customer', 'department', 'comments', 'checklist']));
    }

    public function update(TaskRequest $request, Task $task)
    {
        return new TaskResource($this->tasks->update($task, $request->validated()));
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return response()->noContent();
    }
}
