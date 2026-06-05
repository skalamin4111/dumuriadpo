<x-app-layout title="Reports">
    <div class="grid gap-6 xl:grid-cols-[24rem_1fr]">
        <form method="POST" action="{{ route('reports.store') }}" class="surface p-5">
            @csrf
            <h2 class="mb-4 font-semibold">Submit daily report</h2>
            <input class="field mb-3" type="date" name="report_date" value="{{ today()->toDateString() }}" required>
            <textarea class="field mb-3" name="completed_works" placeholder="Completed works" required></textarea>
            <input class="field mb-3" name="time_spent_minutes" type="number" min="0" placeholder="Time spent in minutes" required>
            <textarea class="field mb-3" name="pending_work" placeholder="Pending work"></textarea>
            <textarea class="field mb-3" name="problems_faced" placeholder="Problems faced"></textarea>
            <button class="btn btn-primary w-full"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>Submit report</button>
        </form>
        <div class="surface overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="table-head"><tr><th class="px-4 py-3">Employee</th><th class="px-4 py-3">Date</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Time</th></tr></thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">@foreach($reports as $report)<tr class="table-row"><td class="px-4 py-3">{{ $report->employee?->user?->name }}</td><td class="px-4 py-3">{{ $report->report_date->format('M j, Y') }}</td><td class="px-4 py-3"><span class="badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ str_replace('_',' ',$report->review_status) }}</span></td><td class="px-4 py-3">{{ $report->time_spent_minutes }} min</td></tr>@endforeach</tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $reports->links() }}</div>
</x-app-layout>
