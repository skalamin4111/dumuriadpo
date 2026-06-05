<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return Employee::query()
            ->with(['user', 'department'])
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->whereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->when($filters['department_id'] ?? null, fn ($query, $department) => $query->where('department_id', $department))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate($filters['per_page'] ?? 15);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data)->load(['user', 'department']);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee->refresh()->load(['user', 'department']);
    }
}
