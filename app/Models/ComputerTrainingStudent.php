<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerTrainingStudent extends Model
{
    use BelongsToCompany;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'student_id',
        'name',
        'phone',
        'guardian_phone',
        'email',
        'course',
        'admission_date',
        'status',
        'address',
        'notes',
    ];

    protected function casts(): array
    {
        return ['admission_date' => 'date'];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ComputerTrainingAttendance::class, 'student_id');
    }

    public function fees(): HasMany
    {
        return $this->hasMany(ComputerTrainingFee::class, 'student_id');
    }
}
