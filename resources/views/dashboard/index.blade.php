<x-app-layout title="Dashboard">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['Total employees', $stats['total_employees'], 'from active directory', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.67 0-5 1.34-5 3v2h10v-2c0-1.66-2.33-3-5-3Z'],
            ['Active tasks', $stats['active_tasks'], 'new and in progress', 'M9 6h11M9 12h11M9 18h11M4 6l1 1 2-2M4 12l1 1 2-2M4 18l1 1 2-2'],
            ['Pending tasks', $stats['pending_tasks'], 'blocked or approval', 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['Overdue tasks', $stats['overdue_tasks'], 'need attention', 'M12 9v4M12 17h.01M10.3 4.3 2.4-1.3 2.4 1.3 5.6 9.7c.8 1.4-.2 3.2-1.9 3.2H5.1c-1.7 0-2.7-1.8-1.9-3.2l5.6-9.7Z'],
        ] as [$label, $value, $hint, $path])
            <div class="surface p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $label }}</p>
                        <p class="mt-3 text-3xl font-bold">{{ $value }}</p>
                    </div>
                    <span class="icon-box text-teal-600 dark:text-teal-300">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                    </span>
                </div>
                <p class="mt-3 text-xs text-slate-500">{{ $hint }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.25fr_.75fr]">
        <div class="surface p-5">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-semibold">Task Completion</h2>
                <span class="text-sm text-slate-500">{{ $stats['completed_tasks'] }} completed</span>
            </div>
            <canvas id="taskChart" height="110"></canvas>
        </div>
        <div class="surface p-5">
            <h2 class="font-semibold">Recent Activity</h2>
            <div class="mt-4 space-y-3">
                @forelse ($stats['recent_tasks'] as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="block rounded-md border border-slate-100 p-3 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-800">
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-medium">{{ $task->title }}</p>
                            <span class="badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ str_replace('_', ' ', $task->status) }}</span>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ $task->assignee?->user?->name ?? 'Unassigned' }} · {{ $task->customer?->name ?? 'Internal' }}</p>
                    </a>
                @empty
                    <p class="text-sm text-slate-500">No activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('taskChart'), {
                type: 'bar',
                data: {
                    labels: ['Active', 'Pending', 'Overdue', 'Completed', 'Today'],
                    datasets: [{
                        label: 'Tasks',
                        data: [{{ $stats['active_tasks'] }}, {{ $stats['pending_tasks'] }}, {{ $stats['overdue_tasks'] }}, {{ $stats['completed_tasks'] }}, {{ $stats['today_tasks'] }}],
                        backgroundColor: ['#0f766e', '#ca8a04', '#dc2626', '#16a34a', '#2563eb'],
                        borderRadius: 8
                    }]
                },
                options: {responsive: true, plugins: {legend: {display: false}}, scales: {y: {beginAtZero: true, ticks: {precision: 0}}}}
            });
        });
    </script>
</x-app-layout>
