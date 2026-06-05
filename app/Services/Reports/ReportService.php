<?php

namespace App\Services\Reports;

use App\Models\CustomerInteraction;
use App\Models\DailyReport;
use App\Models\Task;
use Illuminate\Support\Collection;

class ReportService
{
    public function taskAnalytics(array $filters = []): array
    {
        $query = Task::query()
            ->when($filters['department_id'] ?? null, fn ($q, $value) => $q->where('department_id', $value))
            ->when($filters['from'] ?? null, fn ($q, $value) => $q->whereDate('created_at', '>=', $value))
            ->when($filters['to'] ?? null, fn ($q, $value) => $q->whereDate('created_at', '<=', $value));

        return [
            'total' => (clone $query)->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'overdue' => (clone $query)->where('status', 'overdue')->count(),
            'by_status' => (clone $query)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'by_priority' => (clone $query)->selectRaw('priority, count(*) as total')->groupBy('priority')->pluck('total', 'priority'),
        ];
    }

    public function employeePerformance(array $filters = []): Collection
    {
        return DailyReport::query()
            ->with('employee.user')
            ->when($filters['from'] ?? null, fn ($q, $value) => $q->whereDate('report_date', '>=', $value))
            ->when($filters['to'] ?? null, fn ($q, $value) => $q->whereDate('report_date', '<=', $value))
            ->selectRaw('employee_id, count(*) as reports_count, sum(time_spent_minutes) as minutes')
            ->groupBy('employee_id')
            ->get();
    }

    public function customerInteractions(array $filters = []): Collection
    {
        return CustomerInteraction::query()
            ->with(['customer', 'user'])
            ->latest('interaction_at')
            ->limit($filters['limit'] ?? 100)
            ->get();
    }
}
