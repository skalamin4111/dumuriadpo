<x-app-layout title="Task Detail">
    <div class="grid gap-6 xl:grid-cols-[1fr_22rem]">
        <section class="surface p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div><h2 class="text-2xl font-bold">{{ $task->title }}</h2><p class="mt-1 text-sm text-slate-500">{{ $task->customer?->name ?? 'Internal task' }}</p></div>
                <span class="badge w-fit bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-200">{{ str_replace('_', ' ', $task->status) }}</span>
            </div>
            <p class="mt-5 whitespace-pre-line text-slate-700 dark:text-slate-300">{{ $task->description ?: 'No description provided.' }}</p>
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div><p class="text-xs text-slate-500">Assignee</p><p class="font-medium">{{ $task->assignee?->user?->name ?? '-' }}</p></div>
                <div><p class="text-xs text-slate-500">Priority</p><p class="font-medium">{{ $task->priority }}</p></div>
                <div><p class="text-xs text-slate-500">Deadline</p><p class="font-medium">{{ $task->deadline_at?->format('M j, Y g:i A') ?? '-' }}</p></div>
            </div>
        </section>
        <aside class="space-y-4">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="surface p-5">
                @csrf @method('PUT')
                <h2 class="mb-4 font-semibold">Update progress</h2>
                <select class="field mb-3" name="status">@foreach(\App\Models\Task::STATUSES as $status)<option value="{{ $status }}" @selected($task->status===$status)>{{ str_replace('_',' ',$status) }}</option>@endforeach</select>
                <input class="field mb-3" name="progress" type="number" min="0" max="100" value="{{ $task->progress }}">
                <textarea class="field mb-3" name="delay_reason" placeholder="Delay reason">{{ $task->delay_reason }}</textarea>
                <input type="hidden" name="title" value="{{ $task->title }}"><input type="hidden" name="priority" value="{{ $task->priority }}">
                <button class="btn btn-primary w-full"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>Save update</button>
            </form>
            <div class="surface p-5"><h2 class="font-semibold">Checklist</h2><div class="mt-3 space-y-2">@forelse($task->checklist as $item)<label class="flex items-center gap-2 text-sm"><input class="rounded border-slate-300 text-teal-600 focus:ring-teal-500" type="checkbox" @checked($item->is_completed)> {{ $item->title }}</label>@empty<p class="text-sm text-slate-500">No checklist items.</p>@endforelse</div></div>
        </aside>
    </div>
</x-app-layout>
