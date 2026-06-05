<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can($this->route('task') ? 'update tasks' : 'create tasks');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'urgent', 'critical'])],
            'status' => ['nullable', Rule::in(['new', 'assigned', 'in_progress', 'on_hold', 'pending_review', 'completed', 'pending_approval', 'rejected', 'cancelled', 'overdue'])],
            'assigned_employee_id' => ['nullable', 'exists:employees,id'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'deadline_at' => ['nullable', 'date'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'delay_reason' => ['nullable', 'required_if:status,overdue', 'string'],
            'delay_status' => ['nullable', 'string', 'max:255'],
            'expected_completion_at' => ['nullable', 'date'],
            'approval_comments' => ['nullable', 'string'],
            'checklist' => ['nullable', 'array'],
            'checklist.*' => ['string', 'max:255'],
            'attachments.*' => ['file', 'max:10240'],
        ];
    }
}
