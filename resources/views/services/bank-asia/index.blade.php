<x-app-layout title="Bank Asia Service Portal">
    {{-- Hero Section --}}
    <div class="mb-8 relative overflow-hidden rounded-2xl border border-slate-200/50 bg-white/40 p-8 backdrop-blur-xl shadow-sm dark:border-slate-800/50 dark:bg-slate-900/40">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-500/10 to-indigo-500/10 dark:from-teal-500/5 dark:to-indigo-500/5"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-400/20 rounded-full blur-3xl opacity-50 dark:bg-teal-600/10"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="grid size-12 place-items-center rounded-xl bg-teal-600 text-white shadow-md">B</span>
                    Bank Asia Agent Banking Services
                </h1>
                <p class="mt-2 text-slate-500 dark:text-slate-400 max-w-2xl text-lg">
                    Manage bank account creations, client transaction profile updates, savings certificates (Shonchoy Potro), and track investments.
                </p>
            </div>
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 mb-8">
        {{-- Card 1: Total A/C Creations --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 opacity-10 blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Total Accounts</p>
                    <div class="mt-4 flex items-baseline gap-2">
                        <p class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">{{ $stats['total_accounts'] }}</p>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300">
                            {{ $stats['pending_accounts'] }} Pending
                        </span>
                    </div>
                </div>
                <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 shadow-inner">
                    <svg class="size-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="mt-5 flex items-center text-sm">
                <span class="text-slate-500 font-medium dark:text-slate-400">Applications created</span>
            </div>
        </div>

        {{-- Card 2: TP Profile Updates --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-gradient-to-br from-teal-500 to-emerald-500 opacity-10 blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">TP Profile Updates</p>
                    <div class="mt-4 flex items-baseline gap-2">
                        <p class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">{{ $stats['total_tp_updates'] }}</p>
                    </div>
                </div>
                <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-500 shadow-inner">
                    <svg class="size-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </div>
            </div>
            <div class="mt-5 flex items-center text-sm">
                <span class="text-slate-500 font-medium dark:text-slate-400">Transaction profile updates</span>
            </div>
        </div>

        {{-- Card 3: Active Savings Certificates --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-gradient-to-br from-purple-500 to-fuchsia-500 opacity-10 blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Active Certificates</p>
                    <div class="mt-4 flex items-baseline gap-2">
                        <p class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">{{ $stats['active_certificates'] }}</p>
                    </div>
                </div>
                <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-fuchsia-500 shadow-inner">
                    <svg class="size-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
            </div>
            <div class="mt-5 flex items-center text-sm">
                <span class="text-slate-500 font-medium dark:text-slate-400">Shonchoy Potro records</span>
            </div>
        </div>

        {{-- Card 4: Total Investments --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm dark:border-slate-800/80 dark:bg-slate-900/80 backdrop-blur-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-gradient-to-br from-amber-500 to-rose-500 opacity-10 blur-2xl group-hover:opacity-20 transition-opacity duration-500"></div>
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Total Investment</p>
                    <div class="mt-4 flex items-baseline gap-2">
                        <p class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">৳ {{ number_format($stats['total_investment']) }}</p>
                    </div>
                </div>
                <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-amber-500 to-rose-500 shadow-inner">
                    <span class="text-xl font-black text-white">৳</span>
                </div>
            </div>
            <div class="mt-5 flex items-center text-sm">
                <span class="text-slate-500 font-medium dark:text-slate-400">Invested in active certificates</span>
            </div>
        </div>
    </div>

    {{-- Quick Access Section --}}
    <div class="mb-8">
        <h2 class="mb-4 text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200">Quick Operations</h2>
        <div class="grid gap-6 sm:grid-cols-3">
            {{-- Action 1: Bank A/C Creations --}}
            <div class="surface p-6 flex flex-col justify-between h-48 border border-slate-200 hover:border-teal-500 dark:border-slate-800 dark:hover:border-teal-400 transition-all duration-300 rounded-2xl group shadow-sm hover:shadow-md">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="grid size-10 place-items-center rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Account Creations</h3>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-3 line-clamp-2">Create and manage client bank account applications with nominee photos, NIDs, and signature captures.</p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('bank-asia.ac-creations.create') }}" class="text-xs text-teal-600 dark:text-teal-400 font-semibold flex items-center gap-1 hover:underline">
                        + New Account
                    </a>
                    <a href="{{ route('bank-asia.ac-creations.index') }}" class="btn btn-muted py-1.5 px-3 text-xs">
                        Manage
                    </a>
                </div>
            </div>

            {{-- Action 2: TP Profile Updates --}}
            <div class="surface p-6 flex flex-col justify-between h-48 border border-slate-200 hover:border-teal-500 dark:border-slate-800 dark:hover:border-teal-400 transition-all duration-300 rounded-2xl group shadow-sm hover:shadow-md">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="grid size-10 place-items-center rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">TP Updates</h3>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-3 line-clamp-2">Request and update Transaction Profile (TP) limit modifications for high-volume savings/current accounts.</p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('bank-asia.tp-updates.create') }}" class="text-xs text-teal-600 dark:text-teal-400 font-semibold flex items-center gap-1 hover:underline">
                        + New TP Update
                    </a>
                    <a href="{{ route('bank-asia.tp-updates.index') }}" class="btn btn-muted py-1.5 px-3 text-xs">
                        Manage
                    </a>
                </div>
            </div>

            {{-- Action 3: Shonchoy Potros --}}
            <div class="surface p-6 flex flex-col justify-between h-48 border border-slate-200 hover:border-teal-500 dark:border-slate-800 dark:hover:border-teal-400 transition-all duration-300 rounded-2xl group shadow-sm hover:shadow-md">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="grid size-10 place-items-center rounded-lg bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Shonchoy Potro</h3>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-xs mt-3 line-clamp-2">Register purchased savings certificates, track maturity dates, interest rates, and upload photocopy records.</p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('bank-asia.shonchoy-potros.create') }}" class="text-xs text-teal-600 dark:text-teal-400 font-semibold flex items-center gap-1 hover:underline">
                        + Register Certificate
                    </a>
                    <a href="{{ route('bank-asia.shonchoy-potros.index') }}" class="btn btn-muted py-1.5 px-3 text-xs">
                        Manage
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Activity & Lists Grid --}}
    <div class="grid gap-8 xl:grid-cols-2">
        {{-- Recent Accounts Created --}}
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Recent Account Creations</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Latest A/C applications generated</p>
                    </div>
                    <a href="{{ route('bank-asia.ac-creations.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300">
                        View all
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500">
                                <th class="py-2">Date</th>
                                <th class="py-2">Applicant</th>
                                <th class="py-2">Mobile</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($recentAcCreations as $ac)
                                <tr>
                                    <td class="py-2.5">{{ $ac->date->format('Y-m-d') }}</td>
                                    <td class="py-2.5 font-semibold text-slate-800 dark:text-slate-200">{{ $ac->applicant_name_en }}</td>
                                    <td class="py-2.5">{{ $ac->mobile_number }}</td>
                                    <td class="py-2.5">
                                        <span class="inline-flex items-center rounded-md px-2 py-0.5 font-bold uppercase text-[9px]
                                            @if($ac->status === 'approved') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300
                                            @elseif($ac->status === 'rejected') bg-red-50 text-red-700 dark:bg-red-950/70 dark:text-red-300
                                            @elseif($ac->status === 'submitted') bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300
                                            @else bg-amber-50 text-amber-700 dark:bg-amber-950/70 dark:text-amber-300 @endif">
                                            {{ $ac->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">No recent applications.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Shonchoy Potros --}}
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">Recent Shonchoy Potros</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Latest savings certificates registered</p>
                    </div>
                    <a href="{{ route('bank-asia.shonchoy-potros.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300">
                        View all
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 text-slate-500">
                                <th class="py-2">Type</th>
                                <th class="py-2">Purchaser</th>
                                <th class="py-2">Amount</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($recentCertificates as $cp)
                                <tr>
                                    <td class="py-2.5 font-semibold text-slate-800 dark:text-slate-200">{{ $cp->certificate_type_label }}</td>
                                    <td class="py-2.5">{{ $cp->purchaser_name }}</td>
                                    <td class="py-2.5 font-semibold">৳ {{ number_format($cp->purchase_amount) }}</td>
                                    <td class="py-2.5">
                                        <span class="inline-flex items-center rounded-md px-2 py-0.5 font-bold uppercase text-[9px]
                                            @if($cp->status === 'active') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300
                                            @elseif($cp->status === 'matured') bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300
                                            @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                                            {{ $cp->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">No recent certificates.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
