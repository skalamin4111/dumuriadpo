<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function __construct(private readonly EmployeeRepositoryInterface $employees)
    {
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        return $this->employees->paginate($filters);
    }

    public function create(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'company_id' => auth()->user()?->company_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] ?? 'password',
                'is_active' => ($data['status'] ?? 'active') === 'active',
                'email_verified_at' => now(),
            ]);

            $user->assignRole($data['role'] ?? 'Employee');

            return $this->employees->create([
                ...$data,
                'company_id' => $user->company_id,
                'user_id' => $user->id,
                'employee_code' => $data['employee_code'] ?? 'EMP-'.str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        return DB::transaction(function () use ($employee, $data) {
            $employee->user->update([
                'name' => $data['name'] ?? $employee->user->name,
                'email' => $data['email'] ?? $employee->user->email,
                'is_active' => ($data['status'] ?? $employee->status) === 'active',
            ]);

            if (isset($data['role'])) {
                $employee->user->syncRoles([$data['role']]);
            }

            return $this->employees->update($employee, $data);
        });
    }
}
