<?php

namespace App\Policies;

use App\Models\DailyReport;
use App\Models\User;

class DailyReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view reports');
    }

    public function view(User $user, DailyReport $dailyReport): bool
    {
        return $user->can('view reports') || $dailyReport->employee_id === $user->employee?->id;
    }

    public function create(User $user): bool
    {
        return $user->can('create reports');
    }

    public function update(User $user, DailyReport $dailyReport): bool
    {
        return $user->can('review reports');
    }
}
