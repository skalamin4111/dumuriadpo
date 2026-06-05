<?php

namespace App\Providers;

use App\Events\TaskAssigned;
use App\Events\TaskOverdue;
use App\Models\Customer;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\Task;
use App\Listeners\SendTaskAssignedNotification;
use App\Listeners\SendTaskOverdueNotification;
use App\Observers\TaskObserver;
use App\Policies\CustomerPolicy;
use App\Policies\DailyReportPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\TaskPolicy;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\EmployeeRepository;
use App\Repositories\Eloquent\TaskRepository;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    public function boot(): void
    {
        Gate::policy(Employee::class, EmployeePolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Task::class, TaskPolicy::class);
        Gate::policy(DailyReport::class, DailyReportPolicy::class);
        Task::observe(TaskObserver::class);
        Event::listen(TaskAssigned::class, SendTaskAssignedNotification::class);
        Event::listen(TaskOverdue::class, SendTaskOverdueNotification::class);
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(120)->by($request->user()?->id ?: $request->ip()));
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));

        foreach ([Employee::class, Customer::class, Task::class, DailyReport::class] as $model) {
            $model::created(fn ($record) => app(AuditLogService::class)->record('created', $record, [], $record->getAttributes()));
            $model::updated(fn ($record) => app(AuditLogService::class)->record('updated', $record, $record->getOriginal(), $record->getChanges()));
            $model::deleted(fn ($record) => app(AuditLogService::class)->record('deleted', $record, $record->getOriginal(), []));
        }
    }
}
