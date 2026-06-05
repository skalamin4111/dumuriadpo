<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComputerTrainingExam extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'class_schedule_id',
        'title',
        'course',
        'exam_date',
        'starts_at',
        'total_marks',
        'syllabus',
    ];

    protected function casts(): array
    {
        return ['exam_date' => 'date'];
    }

    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ComputerTrainingClassSchedule::class, 'class_schedule_id');
    }
}
