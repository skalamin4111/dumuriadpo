<x-app-layout title="Search">
    <form class="mb-5 flex max-w-xl gap-2"><input class="field" name="q" value="{{ $term }}" placeholder="Search tasks, customers, employees"><button class="btn btn-primary"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>Search</button></form>
    <div class="grid gap-4 lg:grid-cols-3">
        <section class="surface p-5"><h2 class="font-semibold">Tasks</h2><div class="mt-3 space-y-2">@forelse($tasks as $task)<a class="block text-sm text-teal-700 hover:text-teal-800 dark:text-teal-300 dark:hover:text-teal-200" href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>@empty<p class="text-sm text-slate-500">No tasks found.</p>@endforelse</div></section>
        <section class="surface p-5"><h2 class="font-semibold">Customers</h2><div class="mt-3 space-y-2">@forelse($customers as $customer)<p class="text-sm">{{ $customer->name }} <span class="text-slate-500">{{ $customer->company_name }}</span></p>@empty<p class="text-sm text-slate-500">No customers found.</p>@endforelse</div></section>
        <section class="surface p-5"><h2 class="font-semibold">Employees</h2><div class="mt-3 space-y-2">@forelse($employees as $employee)<p class="text-sm">{{ $employee->user->name }} <span class="text-slate-500">{{ $employee->designation }}</span></p>@empty<p class="text-sm text-slate-500">No employees found.</p>@endforelse</div></section>
    </div>
</x-app-layout>
