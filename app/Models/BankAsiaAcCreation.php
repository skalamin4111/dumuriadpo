<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAsiaAcCreation extends Model
{
    use HasFactory, BelongsToCompany;

    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'date_of_birth' => 'date',
        'monthly_income' => 'decimal:2',
        'nominee_share_percent' => 'integer',
    ];
}
