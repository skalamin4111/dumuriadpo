<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComputerTrainingAttendance extends Model
{
    use BelongsToCompany;

    protected $appends = ['today_mark'];

    public function getTodayMarkAttribute(): int
    {
        if ($this->status === 'absent') {
            if ($this->is_advance_absence) {
                return 0;
            }
            return -2;
        }
        if ($this->status === 'late') {
            return 5;
        }
        if ($this->status === 'present') {
            if ($this->daily_rank == 1) {
                return 10;
            }
            if ($this->daily_rank == 2) {
                return 5;
            }
            if ($this->daily_rank == 3) {
                return 3;
            }
            return 5;
        }
        return 0;
    }

    protected $fillable = [
        'company_id',
        'student_id',
        'class_schedule_id',
        'attendance_date',
        'status',
        'daily_rank',
        'remarks',
        'is_advance_absence',
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
