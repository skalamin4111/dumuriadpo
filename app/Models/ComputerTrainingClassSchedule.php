<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComputerTrainingClassSchedule extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'course',
        'batch_id',
        'batch_name',
        'class_number',
        'instructor',
        'room',
        'class_date',
        'starts_at',
        'ends_at',
        'topic',
    ];

    public function batch()
    {
        return $this->belongsTo(ComputerTrainingBatch::class);
    }

    protected function casts(): array
    {
        return ['class_date' => 'date'];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ComputerTrainingAttendance::class, 'class_schedule_id');
    }
}
