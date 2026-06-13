<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BankAsiaTpUpdate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BankAsiaTpUpdateController extends Controller
{
    public function index(): View
    {
        $tpUpdates = BankAsiaTpUpdate::latest()->paginate(10);
        return view('services.bank-asia.tp-updates.index', compact('tpUpdates'));
    }

    public function create(): View
    {
        return view('services.bank-asia.tp-updates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'account_number' => 'required|string',
            'account_name' => 'required|string',
            'account_type' => 'required|string',
            'date' => 'required|date',
            'is_undertaking_checked' => 'nullable',
            'animal_quantity' => 'required_with:is_undertaking_checked|nullable|integer',
            'total_amount' => 'required_with:is_undertaking_checked|nullable|numeric',
            'regular_daily_tx_count' => 'nullable|integer',
            'regular_daily_tx_amount' => 'nullable|numeric',
            'regular_monthly_tx_count' => 'nullable|integer',
            'regular_monthly_tx_amount' => 'nullable|numeric',
            'regular_withdrawal_daily_count' => 'nullable|integer',
            'regular_withdrawal_daily_amount' => 'nullable|numeric',
            'regular_withdrawal_monthly_count' => 'nullable|integer',
            'regular_withdrawal_monthly_amount' => 'nullable|numeric',
            'regular_transfer_daily_count' => 'nullable|integer',
            'regular_transfer_daily_amount' => 'nullable|numeric',
            'regular_transfer_monthly_count' => 'nullable|integer',
            'regular_transfer_monthly_amount' => 'nullable|numeric',
            'one_time_cash_deposit_count' => 'nullable|integer',
            'one_time_cash_deposit_amount' => 'nullable|numeric',
            'one_time_cash_deposit_monthly_count' => 'nullable|integer',
            'one_time_cash_deposit_monthly_amount' => 'nullable|numeric',
            'one_time_cash_withdrawal_count' => 'nullable|integer',
            'one_time_cash_withdrawal_amount' => 'nullable|numeric',
            'one_time_cash_withdrawal_monthly_count' => 'nullable|integer',
            'one_time_cash_withdrawal_monthly_amount' => 'nullable|numeric',
            'one_time_transfer_count' => 'nullable|integer',
            'one_time_transfer_amount' => 'nullable|numeric',
            'one_time_transfer_monthly_count' => 'nullable|integer',
            'one_time_transfer_monthly_amount' => 'nullable|numeric',
            'source_of_funds' => 'nullable|string',
            'client_mobile' => 'required|string',
            'agent_name' => 'nullable|string',
            'agent_designation' => 'nullable|string',
            'agent_mobile' => 'nullable|string',
            'outlet_name_address' => 'nullable|string',
        ]);

        $hasTxData = collect($validated)->only([
            'regular_daily_tx_count', 'regular_daily_tx_amount', 'regular_monthly_tx_count', 'regular_monthly_tx_amount',
            'regular_withdrawal_daily_count', 'regular_withdrawal_daily_amount', 'regular_withdrawal_monthly_count', 'regular_withdrawal_monthly_amount',
            'regular_transfer_daily_count', 'regular_transfer_daily_amount', 'regular_transfer_monthly_count', 'regular_transfer_monthly_amount',
            'one_time_cash_deposit_count', 'one_time_cash_deposit_amount', 'one_time_cash_deposit_monthly_count', 'one_time_cash_deposit_monthly_amount',
            'one_time_cash_withdrawal_count', 'one_time_cash_withdrawal_amount', 'one_time_cash_withdrawal_monthly_count', 'one_time_cash_withdrawal_monthly_amount',
            'one_time_transfer_count', 'one_time_transfer_amount', 'one_time_transfer_monthly_count', 'one_time_transfer_monthly_amount',
        ])->filter(fn($value) => !is_null($value) && $value !== '')->isNotEmpty();

        if (!$hasTxData) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'transaction_error' => 'At least one transaction amount and count must be filled for Regular or One Time transactions.',
            ]);
        }

        unset($validated['is_undertaking_checked']);

        $tpUpdate = BankAsiaTpUpdate::create($validated);

        return redirect()->route('bank-asia.tp-updates.show', $tpUpdate)->with('status', 'TP Update created successfully.');
    }

    public function show(BankAsiaTpUpdate $tpUpdate): View
    {
        return view('services.bank-asia.tp-updates.show', compact('tpUpdate'));
    }

    public function edit(BankAsiaTpUpdate $tpUpdate): View
    {
        return view('services.bank-asia.tp-updates.edit', compact('tpUpdate'));
    }

    public function update(Request $request, BankAsiaTpUpdate $tpUpdate): RedirectResponse
    {
        $validated = $request->validate([
            'account_number' => 'required|string',
            'account_name' => 'required|string',
            'account_type' => 'required|string',
            'date' => 'required|date',
            'is_undertaking_checked' => 'nullable',
            'animal_quantity' => 'required_with:is_undertaking_checked|nullable|integer',
            'total_amount' => 'required_with:is_undertaking_checked|nullable|numeric',
            'regular_daily_tx_count' => 'nullable|integer',
            'regular_daily_tx_amount' => 'nullable|numeric',
            'regular_monthly_tx_count' => 'nullable|integer',
            'regular_monthly_tx_amount' => 'nullable|numeric',
            'regular_withdrawal_daily_count' => 'nullable|integer',
            'regular_withdrawal_daily_amount' => 'nullable|numeric',
            'regular_withdrawal_monthly_count' => 'nullable|integer',
            'regular_withdrawal_monthly_amount' => 'nullable|numeric',
            'regular_transfer_daily_count' => 'nullable|integer',
            'regular_transfer_daily_amount' => 'nullable|numeric',
            'regular_transfer_monthly_count' => 'nullable|integer',
            'regular_transfer_monthly_amount' => 'nullable|numeric',
            'one_time_cash_deposit_count' => 'nullable|integer',
            'one_time_cash_deposit_amount' => 'nullable|numeric',
            'one_time_cash_deposit_monthly_count' => 'nullable|integer',
            'one_time_cash_deposit_monthly_amount' => 'nullable|numeric',
            'one_time_cash_withdrawal_count' => 'nullable|integer',
            'one_time_cash_withdrawal_amount' => 'nullable|numeric',
            'one_time_cash_withdrawal_monthly_count' => 'nullable|integer',
            'one_time_cash_withdrawal_monthly_amount' => 'nullable|numeric',
            'one_time_transfer_count' => 'nullable|integer',
            'one_time_transfer_amount' => 'nullable|numeric',
            'one_time_transfer_monthly_count' => 'nullable|integer',
            'one_time_transfer_monthly_amount' => 'nullable|numeric',
            'source_of_funds' => 'nullable|string',
            'client_mobile' => 'required|string',
            'agent_name' => 'nullable|string',
            'agent_designation' => 'nullable|string',
            'agent_mobile' => 'nullable|string',
            'outlet_name_address' => 'nullable|string',
        ]);

        $hasTxData = collect($validated)->only([
            'regular_daily_tx_count', 'regular_daily_tx_amount', 'regular_monthly_tx_count', 'regular_monthly_tx_amount',
            'regular_withdrawal_daily_count', 'regular_withdrawal_daily_amount', 'regular_withdrawal_monthly_count', 'regular_withdrawal_monthly_amount',
            'regular_transfer_daily_count', 'regular_transfer_daily_amount', 'regular_transfer_monthly_count', 'regular_transfer_monthly_amount',
            'one_time_cash_deposit_count', 'one_time_cash_deposit_amount', 'one_time_cash_deposit_monthly_count', 'one_time_cash_deposit_monthly_amount',
            'one_time_cash_withdrawal_count', 'one_time_cash_withdrawal_amount', 'one_time_cash_withdrawal_monthly_count', 'one_time_cash_withdrawal_monthly_amount',
            'one_time_transfer_count', 'one_time_transfer_amount', 'one_time_transfer_monthly_count', 'one_time_transfer_monthly_amount',
        ])->filter(fn($value) => !is_null($value) && $value !== '')->isNotEmpty();

        if (!$hasTxData) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'transaction_error' => 'At least one transaction amount and count must be filled for Regular or One Time transactions.',
            ]);
        }

        unset($validated['is_undertaking_checked']);

        $tpUpdate->update($validated);

        return redirect()->route('bank-asia.tp-updates.show', $tpUpdate)->with('status', 'TP Update updated successfully.');
    }

    public function destroy(BankAsiaTpUpdate $tpUpdate): RedirectResponse
    {
        $tpUpdate->delete();

        return redirect()->route('bank-asia.tp-updates.index')->with('status', 'TP Update deleted successfully.');
    }
}
