<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComputerTrainingAttendance extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'student_id',
        'class_schedule_id',
        'attendance_date',
        'status',
        'remarks',
    ];

    protected function casts(): array
    {
        return ['attendance_date' => 'date'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(ComputerTrainingStudent::class, 'student_id');
    }

    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ComputerTrainingClassSchedule::class, 'class_schedule_id');
    }
}
