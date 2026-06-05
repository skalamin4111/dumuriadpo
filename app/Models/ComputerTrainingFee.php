<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComputerTrainingFee extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'student_id',
        'amount',
        'paid_amount',
        'due_date',
        'paid_at',
        'status',
        'payment_method',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'due_date' => 'date',
            'paid_at' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(ComputerTrainingStudent::class, 'student_id');
    }
}
