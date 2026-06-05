<?php

namespace App\Services;

use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function stats(): array
    {
        $user = Auth::user();
        $employeeId = $user?->employee?->id;

        $taskQuery = Task::query();
        if ($user?->hasRole('Employee') && $employeeId) {
            $taskQuery->where('assigned_employee_id', $employeeId);
        }

        return [
            'total_employees' => Employee::count(),
            'active_tasks' => (clone $taskQuery)->whereIn('status', ['new', 'assigned', 'in_progress'])->count(),
            'pending_tasks' => (clone $taskQuery)->whereIn('status', ['on_hold', 'pending_approval', 'overdue'])->count(),
            'overdue_tasks' => (clone $taskQuery)->where('deadline_at', '<', now())->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'completed_tasks' => (clone $taskQuery)->whereIn('status', ['completed', 'pending_approval'])->count(),
            'today_tasks' => (clone $taskQuery)->whereDate('deadline_at', today())->count(),
            'recent_tasks' => (clone $taskQuery)->with(['assignee.user', 'customer'])->latest()->limit(8)->get(),
            'recent_reports' => DailyReport::with('employee.user')->latest()->limit(5)->get(),
        ];
    }
}
