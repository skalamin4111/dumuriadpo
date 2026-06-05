<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Task::query()
            ->with(['assignee.user', 'customer', 'department'])
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($filters['department_id'] ?? null, fn ($query, $department) => $query->where('department_id', $department))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->when($filters['priority'] ?? null, fn ($query, $priority) => $query->where('priority', $priority))
            ->when($filters['assigned_employee_id'] ?? null, fn ($query, $employee) => $query->where('assigned_employee_id', $employee))
            ->orderByRaw("FIELD(priority, 'critical', 'urgent', 'high', 'medium', 'low')")
            ->orderBy('deadline_at')
            ->paginate($filters['per_page'] ?? 15);
    }

    public function create(array $data): Task
    {
        return Task::create($data)->load(['assignee.user', 'customer', 'department']);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->refresh()->load(['assignee.user', 'customer', 'department']);
    }
}
