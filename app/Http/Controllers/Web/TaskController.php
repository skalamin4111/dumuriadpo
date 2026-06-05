<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
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

        return view('tasks.index', [
            'tasks' => $this->tasks->paginate($request->query()),
            'employees' => Employee::with('user')->where('status', 'active')->get(),
            'customers' => Customer::orderBy('name')->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', ['task' => $task->load(['assignee.user', 'customer', 'department', 'comments', 'checklist'])]);
    }

    public function store(TaskRequest $request)
    {
        $this->tasks->create($request->validated());
        return back()->with('status', 'Task created.');
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->tasks->update($task, $request->validated());
        return back()->with('status', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return back()->with('status', 'Task archived.');
    }
}
