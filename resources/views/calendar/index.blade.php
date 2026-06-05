<x-app-layout title="Calendar">
    <div class="grid gap-4 lg:grid-cols-3">
        @foreach ($tasks->groupBy(fn($task) => $task->deadline_at?->format('Y-m-d')) as $date => $items)
            <section class="surface p-4">
                <h2 class="flex items-center gap-2 font-semibold"><span class="icon-box size-8 text-teal-600 dark:text-teal-300"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 3v4M17 3v4M4 9h16M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z"/></svg></span>{{ \Carbon\Carbon::parse($date)->format('D, M j') }}</h2>
                <div class="mt-3 space-y-2">
                    @foreach ($items as $task)
                        <a href="{{ route('tasks.show', $task) }}" class="block rounded-md border border-slate-100 p-3 text-sm transition hover:border-teal-200 hover:bg-slate-50 dark:border-slate-800 dark:hover:border-teal-900 dark:hover:bg-slate-800">
                            <span class="font-medium">{{ $task->title }}</span>
                            <span class="mt-1 block text-xs text-slate-500">{{ $task->deadline_at->format('g:i A') }} · {{ $task->assignee?->user?->name ?? 'Unassigned' }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</x-app-layout>
