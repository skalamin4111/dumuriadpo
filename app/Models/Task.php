<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToCompany;

class Task extends Model
{
    use BelongsToCompany;
    use HasFactory;
    use SoftDeletes;

    public const STATUSES = ['new', 'assigned', 'in_progress', 'on_hold', 'pending_review', 'pending_approval', 'completed', 'rejected', 'cancelled', 'overdue'];
    public const PRIORITIES = ['low', 'medium', 'high', 'urgent', 'critical'];

    protected $fillable = [
        'title',
        'company_id',
        'parent_task_id',
        'task_template_id',
        'description',
        'priority',
        'status',
        'assigned_employee_id',
        'customer_id',
        'department_id',
        'created_by',
        'deadline_at',
        'sla_due_at',
        'completed_at',
        'reviewed_at',
        'reviewed_by',
        'progress',
        'estimated_minutes',
        'actual_minutes',
        'delay_reason',
        'delay_status',
        'expected_completion_at',
        'approval_comments',
        'is_recurring',
        'recurrence_rule',
    ];

    protected function casts(): array
    {
        return [
            'deadline_at' => 'datetime',
            'sla_due_at' => 'datetime',
            'completed_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'expected_completion_at' => 'datetime',
            'progress' => 'integer',
            'is_recurring' => 'boolean',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(TaskTemplate::class, 'task_template_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function checklist(): HasMany
    {
        return $this->hasMany(TaskChecklist::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(TaskDependency::class);
    }

    public function workLogs(): HasMany
    {
        return $this->hasMany(TaskWorkLog::class);
    }
}
