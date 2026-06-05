<x-app-layout title="Task Board">
    <div class="mb-5 flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
        <form class="grid gap-2 sm:grid-cols-2 lg:grid-cols-5">
            <input class="field" name="search" value="{{ request('search') }}" placeholder="Search tasks">
            <select class="field" name="status"><option value="">All status</option>@foreach(\App\Models\Task::STATUSES as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ str_replace('_',' ',$status) }}</option>@endforeach</select>
            <select class="field" name="priority"><option value="">All priority</option>@foreach(\App\Models\Task::PRIORITIES as $priority)<option value="{{ $priority }}" @selected(request('priority')===$priority)>{{ $priority }}</option>@endforeach</select>
            <select class="field" name="department_id"><option value="">Department</option>@foreach($departments as $department)<option value="{{ $department->id }}">{{ $department->name }}</option>@endforeach</select>
            <button class="btn btn-muted">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                Filter
            </button>
        </form>
        @can('create tasks')<button class="btn btn-primary" x-data x-on:click="$dispatch('open-modal', 'task-modal')"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>New task</button>@endcan
    </div>

    <div class="grid gap-4 xl:grid-cols-4">
        @foreach (['new' => 'New', 'in_progress' => 'In Progress', 'pending_approval' => 'Approval', 'overdue' => 'Overdue'] as $key => $label)
            <section class="min-h-72 rounded-lg border border-slate-200 bg-slate-100/70 p-3 dark:border-slate-800 dark:bg-slate-900/60">
                <div class="mb-3 flex items-center justify-between"><h2 class="text-sm font-semibold">{{ $label }}</h2><span class="badge bg-white text-slate-600 dark:bg-slate-950 dark:text-slate-300">{{ $tasks->where('status', $key)->count() }}</span></div>
                <div class="space-y-3">
                    @foreach ($tasks->where('status', $key) as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="block rounded-lg border border-slate-200 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-950 dark:hover:border-teal-900">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="text-sm font-semibold">{{ $task->title }}</h3>
                                <span class="badge {{ in_array($task->priority, ['urgent','critical']) ? 'bg-rose-50 text-rose-700 dark:bg-rose-950 dark:text-rose-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' }}">{{ $task->priority }}</span>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">{{ $task->assignee?->user?->name ?? 'Unassigned' }} · {{ $task->deadline_at?->format('M j') ?? 'No deadline' }}</p>
                            <div class="mt-3 h-2 rounded-full bg-slate-100 dark:bg-slate-800"><div class="h-2 rounded-full bg-teal-600" style="width: {{ $task->progress }}%"></div></div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
    <div class="mt-4">{{ $tasks->links() }}</div>

    <div x-data="{open:false}" x-on:open-modal.window="open = $event.detail === 'task-modal'" x-show="open" class="fixed inset-0 z-40 grid place-items-center bg-slate-950/60 p-4" style="display:none">
        <form method="POST" action="{{ route('tasks.store') }}" class="card max-h-[92vh] w-full max-w-3xl overflow-y-auto p-5">
            @csrf
            <div class="mb-4 flex items-center justify-between"><h2 class="font-semibold">New task</h2><button class="btn btn-muted px-2.5" type="button" x-on:click="open=false" title="Close"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg></button></div>
            <div class="grid gap-3 sm:grid-cols-2">
                <input class="field sm:col-span-2" name="title" placeholder="Task title" required>
                <textarea class="field sm:col-span-2" name="description" placeholder="Description"></textarea>
                <select class="field" name="priority">@foreach(\App\Models\Task::PRIORITIES as $priority)<option value="{{ $priority }}">{{ ucfirst($priority) }}</option>@endforeach</select>
                <input class="field" name="deadline_at" type="datetime-local">
                <select class="field" name="assigned_employee_id"><option value="">Assignee</option>@foreach($employees as $employee)<option value="{{ $employee->id }}">{{ $employee->user->name }}</option>@endforeach</select>
                <select class="field" name="customer_id"><option value="">Customer</option>@foreach($customers as $customer)<option value="{{ $customer->id }}">{{ $customer->name }}</option>@endforeach</select>
                <select class="field" name="department_id"><option value="">Department</option>@foreach($departments as $department)<option value="{{ $department->id }}">{{ $department->name }}</option>@endforeach</select>
                <input class="field" name="progress" type="number" min="0" max="100" value="0">
            </div>
            <div class="mt-4 flex justify-end"><button class="btn btn-primary"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Create task</button></div>
        </form>
    </div>
</x-app-layout>
