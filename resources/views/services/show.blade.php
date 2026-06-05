<x-app-layout :title="$service">
    <section class="surface p-6">
        <div class="flex items-center gap-3">
            <span class="icon-box">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M6 7v14h12V7M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M8 11h8M8 15h8"/></svg>
            </span>
            <div>
                <h2 class="text-base font-semibold">{{ $service }}</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Service details will appear here.</p>
            </div>
        </div>
    </section>
</x-app-layout>
