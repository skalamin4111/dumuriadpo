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
        'batch_name',
        'instructor',
        'room',
        'class_date',
        'starts_at',
        'ends_at',
        'topic',
    ];

    protected function casts(): array
    {
        return ['class_date' => 'date'];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ComputerTrainingAttendance::class, 'class_schedule_id');
    }
}
