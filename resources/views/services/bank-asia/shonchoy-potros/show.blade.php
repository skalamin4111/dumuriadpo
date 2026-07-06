<x-app-layout title="Savings Certificate Details">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('bank-asia.shonchoy-potros.index') }}" class="btn btn-muted flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to List
        </a>
        <div class="flex gap-3">
            <a href="{{ route('bank-asia.shonchoy-potros.edit', $certificate) }}" class="btn btn-primary flex items-center gap-2">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Details
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 mb-8">
        {{-- Purchaser Details Card --}}
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Purchaser Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Full Name</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 text-base">{{ $certificate->purchaser_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">NID Number</span>
                        <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->purchaser_nid }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Phone Number</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->purchaser_phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Date of Birth</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->purchaser_dob->format('Y-m-d') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Address</span>
                        <p class="font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900 p-2.5 rounded-lg border border-slate-200/50 dark:border-slate-800 text-xs mt-1">{{ $certificate->purchaser_address }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Certificate Details Card --}}
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Savings Certificate Details</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Certificate Type</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $certificate->certificate_type_label }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Certificate No.</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->certificate_number }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Registration No.</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->registration_number }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Purchase Date</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->purchase_date->format('Y-m-d') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Maturity Date</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->maturity_date->format('Y-m-d') }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Purchase Amount</span>
                            <span class="font-bold text-lg text-teal-600 dark:text-teal-400">৳ {{ number_format($certificate->purchase_amount, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Interest Rate</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $certificate->interest_rate ?? 'N/A' }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nominee & Status Card --}}
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Nominee & Remarks</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Nominee Name</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $certificate->nominee_name }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Relationship</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->nominee_relation }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Share Percent</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $certificate->nominee_share_percent }}%</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-xs uppercase font-medium">Maturity Status</span>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold uppercase mt-1
                            @if($certificate->status === 'active') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-300
                            @elseif($certificate->status === 'matured') bg-blue-50 text-blue-700 dark:bg-blue-950/70 dark:text-blue-300
                            @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 @endif">
                            {{ $certificate->status }}
                        </span>
                    </div>
                    @if($certificate->notes)
                        <div>
                            <span class="text-slate-500 block text-xs uppercase font-medium">Remarks</span>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 font-medium">{{ $certificate->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Scan Copy Scanned Document Section --}}
    @if($certificate->document_path)
        <div class="surface p-6 rounded-2xl border border-slate-200/60 dark:border-slate-800/80 shadow-sm mb-8">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Scanned Certificate Copy</h3>
            @php
                $extension = strtolower(pathinfo($certificate->document_path, PATHINFO_EXTENSION));
            @endphp

            @if($extension === 'pdf')
                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-100">
                    <iframe src="{{ asset('storage/' . $certificate->document_path) }}" class="w-full h-[600px] border-0" allowfullscreen></iframe>
                </div>
            @else
                <div class="flex items-center justify-center bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-4 overflow-hidden">
                    <img src="{{ asset('storage/' . $certificate->document_path) }}" alt="Scanned Certificate" class="max-w-full max-h-[800px] rounded-lg shadow-sm">
                </div>
            @endif
        </div>
    @endif
</x-app-layout>
