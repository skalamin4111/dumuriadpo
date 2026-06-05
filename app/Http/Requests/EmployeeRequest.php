<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('employee') ? 'update employees' : 'create employees');
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        $userId = $employee?->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.($userId ?? 'NULL')],
            'password' => [$employee ? 'nullable' : 'required', 'string', 'min:8'],
            'role' => ['nullable', 'in:Admin,Manager,Supervisor,Employee,Auditor'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'employee_code' => ['nullable', 'string', 'max:50', 'unique:employees,employee_code,'.($employee?->id ?? 'NULL')],
            'designation' => ['nullable', 'string', 'max:120'],
            'joining_date' => ['nullable', 'date'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string'],
            'emergency_contact' => ['nullable', 'string', 'max:120'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
