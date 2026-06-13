<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAsiaTpUpdate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'total_amount' => 'integer',
        'regular_daily_tx_amount' => 'integer',
        'regular_monthly_tx_amount' => 'integer',
        'regular_withdrawal_daily_amount' => 'integer',
        'regular_withdrawal_monthly_amount' => 'integer',
        'regular_transfer_daily_amount' => 'integer',
        'regular_transfer_monthly_amount' => 'integer',
        'one_time_cash_deposit_amount' => 'integer',
        'one_time_cash_deposit_monthly_amount' => 'integer',
        'one_time_cash_withdrawal_amount' => 'integer',
        'one_time_cash_withdrawal_monthly_amount' => 'integer',
        'one_time_transfer_amount' => 'integer',
        'one_time_transfer_monthly_amount' => 'integer',
    ];
}
