<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'employee_id',
        'company_id',
        'report_date',
        'completed_works',
        'time_spent_minutes',
        'pending_work',
        'problems_faced',
        'review_status',
        'reviewed_by',
        'reviewed_at',
        'manager_comments',
    ];

    protected function casts(): array
    {
        return ['report_date' => 'date', 'reviewed_at' => 'datetime'];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
