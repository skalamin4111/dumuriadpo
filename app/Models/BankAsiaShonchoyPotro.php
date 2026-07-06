<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAsiaShonchoyPotro extends Model
{
    use HasFactory, BelongsToCompany;

    protected $guarded = [];

    protected $casts = [
        'purchaser_dob' => 'date',
        'purchase_date' => 'date',
        'maturity_date' => 'date',
        'purchase_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'nominee_share_percent' => 'integer',
    ];

    public const CERTIFICATE_TYPES = [
        'family' => 'পরিবার সঞ্চয়পত্র (Family Savings Certificate)',
        '3_month_interest' => '৩ মাস অন্তর মুনাফাভিত্তিক সঞ্চয়পত্র (3-Month Interest)',
        'pensioner' => 'পেনশনার সঞ্চয়পত্র (Pensioner Savings Certificate)',
        '5_year_bd' => '৫ বছর মেয়াদী বাংলাদেশ সঞ্চয়পত্র (5-Year Bangladesh)',
    ];

    public function getCertificateTypeLabelAttribute(): string
    {
        return self::CERTIFICATE_TYPES[$this->certificate_type] ?? $this->certificate_type;
    }
}
