<x-app-layout title="Settings">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach ([
            ['Roles and Permissions', 'M16 11c1.66 0 3-1.34 3-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3ZM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Z'],
            ['Notification Channels', 'M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.7 21a2 2 0 0 1-3.4 0'],
            ['Queue and Scheduler', 'M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
            ['API Tokens', 'M15 7h3a4 4 0 1 1 0 8h-3M9 7H6a4 4 0 1 0 0 8h3M8 12h8'],
            ['Company Profile', 'M4 21V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v16M16 8h3a1 1 0 0 1 1 1v12M8 9h4M8 13h4M8 17h4'],
            ['Future Modules', 'M12 5v14M5 12h14'],
        ] as [$item, $path])
            <section class="surface p-5">
                <div class="mb-4 flex items-center gap-3">
                    <span class="icon-box text-teal-600 dark:text-teal-300"><svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg></span>
                    <h2 class="font-semibold">{{ $item }}</h2>
                </div>
                <p class="mt-2 text-sm text-slate-500">Configured through Laravel services and ready for the next ERP expansion stage.</p>
            </section>
        @endforeach
    </div>
</x-app-layout>
