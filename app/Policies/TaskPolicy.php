<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view tasks');
    }

    public function view(User $user, Task $task): bool
    {
        return $user->can('view tasks') || $task->assigned_employee_id === $user->employee?->id;
    }

    public function create(User $user): bool
    {
        return $user->can('create tasks');
    }

    public function update(User $user, Task $task): bool
    {
        return $user->can('update tasks') || $task->assigned_employee_id === $user->employee?->id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->can('delete tasks');
    }
}
