<x-app-layout title="Reminders">
    <div class="grid gap-5 xl:grid-cols-[24rem_1fr]">
        <section class="surface p-5">
            <div class="mb-4">
                <h2 class="font-semibold">Set customer reminder</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Record office visits, service interest, and next follow-up date.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:border-rose-900 dark:bg-rose-950 dark:text-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('reminders.store') }}" class="space-y-3">
                @csrf
                <select class="field" name="customer_id" required>
                    <option value="">Select customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}{{ $customer->phone ? ' - '.$customer->phone : '' }}</option>
                    @endforeach
                </select>

                <select class="field" name="service_section" required>
                    <option value="">Select service section</option>
                    @foreach ($services as $slug => $service)
                        <option value="{{ $slug }}" @selected(old('service_section') === $slug)>{{ $service }}</option>
                    @endforeach
                </select>

                <select class="field" name="contact_type" required>
                    @foreach ($contactTypes as $value => $label)
                        <option value="{{ $value }}" @selected(old('contact_type', 'office_visit') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <input class="field" name="title" value="{{ old('title') }}" placeholder="Reminder title" required>

                <textarea class="field min-h-28" name="purpose" placeholder="Why did the customer come or why did the officer call?" required>{{ old('purpose') }}</textarea>

                <textarea class="field min-h-24" name="follow_up_notes" placeholder="What is needed before the next visit or admission?">{{ old('follow_up_notes') }}</textarea>

                <label class="block">
                    <span class="mb-1 block text-sm font-medium text-slate-600 dark:text-slate-300">Next follow-up date and time</span>
                    <input class="field" name="remind_at" type="datetime-local" value="{{ old('remind_at') }}" required>
                </label>

                <button class="btn btn-primary w-full">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6v6l4 2M5 13a7 7 0 1 0 2.05-4.95M5 5v4h4"/></svg>
                    Save reminder
                </button>
            </form>
        </section>

        <section class="space-y-4">
            <div class="surface p-4">
                <form class="grid gap-3 md:grid-cols-[1fr_12rem_10rem_auto]">
                    <input class="field" name="search" value="{{ request('search') }}" placeholder="Search customer, phone, or purpose">
                    <select class="field" name="service_section">
                        <option value="">All services</option>
                        @foreach ($services as $slug => $service)
                            <option value="{{ $slug }}" @selected(request('service_section') === $slug)>{{ $service }}</option>
                        @endforeach
                    </select>
                    <select class="field" name="status">
                        <option value="">All status</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                    </select>
                    <button class="btn btn-muted">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M7 12h10M10 18h4"/></svg>
                        Filter
                    </button>
                </form>
            </div>

            <div class="grid gap-3">
                @forelse ($reminders as $reminder)
                    <article class="surface p-4">
                        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="font-semibold">{{ $reminder->title }}</h2>
                                    <span class="badge {{ $reminder->status === 'pending' ? 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-200' : ($reminder->status === 'completed' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300') }}">{{ ucfirst($reminder->status) }}</span>
                                    <span class="badge bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-200">{{ $reminder->service_label }}</span>
                                </div>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $reminder->purpose }}</p>
                                @if ($reminder->follow_up_notes)
                                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ $reminder->follow_up_notes }}</p>
                                @endif
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-sm text-slate-500 dark:text-slate-400">
                                    <span>{{ $reminder->customer?->name ?? 'No customer' }}</span>
                                    <span>{{ $reminder->customer?->phone ?? 'No phone' }}</span>
                                    <span>{{ $reminder->contact_type_label }}</span>
                                    <span>Officer: {{ $reminder->officer?->name ?? 'Unknown' }}</span>
                                </div>
                            </div>

                            <div class="shrink-0 space-y-3 lg:text-right">
                                <div>
                                    <p class="text-sm font-semibold {{ $reminder->status === 'pending' && $reminder->remind_at->isPast() ? 'text-rose-600 dark:text-rose-300' : 'text-slate-700 dark:text-slate-200' }}">{{ $reminder->remind_at->format('M j, Y g:i A') }}</p>
                                    <p class="text-xs text-slate-500">{{ $reminder->remind_at->diffForHumans() }}</p>
                                </div>
                                @if ($reminder->status === 'pending')
                                    <div class="flex gap-2 lg:justify-end">
                                        <form method="POST" action="{{ route('reminders.update', $reminder) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button class="btn btn-primary min-h-9 px-3 py-1.5">Done</button>
                                        </form>
                                        <form method="POST" action="{{ route('reminders.update', $reminder) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button class="btn btn-muted min-h-9 px-3 py-1.5">Cancel</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="surface p-6 text-center text-sm text-slate-500 dark:text-slate-400">No reminders found.</div>
                @endforelse
            </div>

            {{ $reminders->links() }}
        </section>
    </div>
</x-app-layout>
