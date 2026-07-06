<x-app-layout title="Savings Certificates (Shonchoy Potro)">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="/services/bank-asia" class="btn btn-muted px-2.5">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight">Savings Certificates (Shonchoy Potro)</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Register and manage client savings certificates and active investments.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('bank-asia.shonchoy-potros.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Register Certificate
            </a>
        </div>
    </div>

    {{-- Search and Filter Form --}}
    <form action="{{ route('bank-asia.shonchoy-potros.index') }}" method="GET" class="surface p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by purchaser name, NID, phone or certificate/registration no..." class="field">
            </div>
            <div class="w-full md:w-48">
                <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Type</label>
                <select name="type" class="field">
                    <option value="">All Types</option>
                    @foreach(\App\Models\BankAsiaShonchoyPotro::CERTIFICATE_TYPES as $key => $label)
                        <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-40">
                <label class="mb-1 block text-xs font-semibold text-slate-500 uppercase tracking-wider dark:text-slate-400">Status</label>
                <select name="status" class="field">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="matured" {{ request('status') === 'matured' ? 'selected' : '' }}>Matured</option>
                    <option value="encashed" {{ request('status') === 'encashed' ? 'selected' : '' }}>Encashed</option>
                </select>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="btn btn-primary w-full md:w-auto px-5">Filter</button>
                <a href="{{ route('bank-asia.shonchoy-potros.index') }}" class="btn btn-muted w-full md:w-auto px-4 text-center">Reset</a>
            </div>
        </div>
    </form>

    {{-- Main Records Table --}}
    <div class="surface overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/75 dark:border-slate-800 dark:bg-slate-900/50 text-slate-500 font-semibold uppercase text-xs">
                        <th class="p-4">Purchaser Details</th>
                        <th class="p-4">Certificate Type</th>
                        <th class="p-4">Numbers</th>
                        <th class="p-4">Purchase / Maturity Date</th>
                        <th class="p-4 text-right">Purchase Amount</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($certificates as $cp)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $cp->purchaser_name }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $cp->purchaser_phone }}</div>
                            </td>
                            <td class="p-4 font-semibold text-slate-700 dark:text-slate-300">
                                {{ $cp->certificate_type_label }}
                            </td>
                            <td class="p-4 font-mono text-xs">
                                <div>Cert: {{ $cp->certificate_number }}</div>
                                <div class="text-slate-500 dark:text-slate-400 mt-0.5">Reg: {{ $cp->registration_number }}</div>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div>Pur: {{ $cp->purchase_date->format('Y-m-d') }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Mat: {{ $cp->maturity_date->format('Y-m-d') }}</div>
                            </td>
                            <td class="p-4 text-right font-bold text-slate-900 dark:text-white">
                                ৳ {{ number_format($cp->purchase_amount, 2) }}
                                @if($cp->interest_rate)
                                    <div class="text-[10px] font-normal text-slate-500 dark:text-slate-400 mt-0.5">Rate: {{ $cp->interest_rate }}%</div>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold uppercase
                                    @if($cp->status === 'active') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300
                                    @elseif($cp->status === 'matured') bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300
                                    @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                                    {{ $cp->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('bank-asia.shonchoy-potros.show', $cp) }}" class="btn btn-muted py-1.5 px-3 text-xs flex items-center gap-1">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        View
                                    </a>
                                    <a href="{{ route('bank-asia.shonchoy-potros.edit', $cp) }}" class="btn btn-muted py-1.5 px-3 text-xs flex items-center gap-1">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('bank-asia.shonchoy-potros.destroy', $cp) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-muted hover:text-red-600 dark:hover:text-red-400 py-1.5 px-3 text-xs flex items-center gap-1">
                                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center py-4">
                                    <svg class="size-12 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                    <p class="font-semibold text-slate-700 dark:text-slate-300">No savings certificates registered</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Try refining your filter conditions or register a new certificate.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($certificates->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
