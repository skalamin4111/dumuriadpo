<x-app-layout title="Bank Asia - TP Updates">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">TP Updates</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage transaction profile update applications.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('bank-asia.tp-updates.create') }}" class="btn btn-primary">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                New TP Update
            </a>
        </div>
    </div>

    <div class="surface overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-800 dark:bg-slate-800 dark:text-slate-400">
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Date</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Account Name</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Account Number</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Type</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium">Amount</th>
                        <th class="whitespace-nowrap px-4 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse ($tpUpdates as $update)
                        @php
                            $regularTypes = [];
                            $regularFreqs = [];
                            if ($update->regular_daily_tx_count || $update->regular_monthly_tx_count) $regularTypes[] = 'Deposit';
                            if ($update->regular_withdrawal_daily_count || $update->regular_withdrawal_monthly_count) $regularTypes[] = 'Withdraw';
                            if ($update->regular_transfer_daily_count || $update->regular_transfer_monthly_count) $regularTypes[] = 'Transfer';
                            
                            if ($update->regular_daily_tx_count || $update->regular_withdrawal_daily_count || $update->regular_transfer_daily_count) $regularFreqs[] = 'Daily';
                            if ($update->regular_monthly_tx_count || $update->regular_withdrawal_monthly_count || $update->regular_transfer_monthly_count) $regularFreqs[] = 'Monthly';

                            $oneTimeTypes = [];
                            $oneTimeFreqs = [];
                            if ($update->one_time_cash_deposit_count || $update->one_time_cash_deposit_monthly_count) $oneTimeTypes[] = 'Deposit';
                            if ($update->one_time_cash_withdrawal_count || $update->one_time_cash_withdrawal_monthly_count) $oneTimeTypes[] = 'Withdraw';
                            if ($update->one_time_transfer_count || $update->one_time_transfer_monthly_count) $oneTimeTypes[] = 'Transfer';
                            
                            if ($update->one_time_cash_deposit_count || $update->one_time_cash_withdrawal_count || $update->one_time_transfer_count) $oneTimeFreqs[] = 'Daily';
                            if ($update->one_time_cash_deposit_monthly_count || $update->one_time_cash_withdrawal_monthly_count || $update->one_time_transfer_monthly_count) $oneTimeFreqs[] = 'Monthly';

                            $amount = $update->total_amount ?: max(
                                $update->regular_daily_tx_amount + $update->one_time_cash_deposit_amount,
                                $update->regular_withdrawal_daily_amount + $update->one_time_cash_withdrawal_amount,
                                $update->regular_transfer_daily_amount + $update->one_time_transfer_amount
                            );
                        @endphp
                        <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800">
                            <td class="whitespace-nowrap px-4 py-3">{{ $update->date }}</td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium">{{ $update->account_name }}</td>
                            <td class="whitespace-nowrap px-4 py-3">{{ $update->account_number }}</td>
                            <td class="whitespace-nowrap px-4 py-3 align-top">
                                <div class="flex flex-col gap-2">
                                    @if(count($regularTypes) > 0)
                                        <div>
                                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/20 dark:text-blue-300 dark:ring-blue-900/50">
                                                Regular - {{ implode(', ', $regularTypes) }}
                                            </span>
                                            @if(count($regularFreqs) > 0)
                                                <div class="mt-1 pl-1 text-[11px] font-medium text-slate-500 dark:text-slate-400">{{ implode(' & ', $regularFreqs) }}</div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if(count($oneTimeTypes) > 0)
                                        <div>
                                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10 dark:bg-purple-900/20 dark:text-purple-300 dark:ring-purple-900/50">
                                                One Time - {{ implode(', ', $oneTimeTypes) }}
                                            </span>
                                            @if(count($oneTimeFreqs) > 0)
                                                <div class="mt-1 pl-1 text-[11px] font-medium text-slate-500 dark:text-slate-400">{{ implode(' & ', $oneTimeFreqs) }}</div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if(count($regularTypes) === 0 && count($oneTimeTypes) === 0)
                                        <span class="text-slate-400 text-xs">N/A</span>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium align-top">
                                {{ $amount > 0 ? '৳ ' . number_format($amount) : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('bank-asia.tp-updates.show', $update) }}" class="btn btn-muted px-2 py-1.5" title="View / Print">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('bank-asia.tp-updates.edit', $update) }}" class="btn btn-muted px-2 py-1.5" title="Edit">
                                        <svg class="size-4 text-blue-600 dark:text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('bank-asia.tp-updates.destroy', $update) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this TP update?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-muted px-2 py-1.5" title="Delete">
                                            <svg class="size-4 text-red-600 dark:text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                                No TP updates found. Create a new one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tpUpdates->hasPages())
            <div class="border-t border-slate-200 p-4 dark:border-slate-800">
                {{ $tpUpdates->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
