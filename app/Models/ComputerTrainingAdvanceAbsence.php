<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComputerTrainingAdvanceAbsence extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'student_id',
        'absence_date',
        'notes',
    ];

    protected function casts(): array
    {
        return ['absence_date' => 'date'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(ComputerTrainingStudent::class, 'student_id');
    }
}
