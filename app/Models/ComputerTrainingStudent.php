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
        'batch_id',
        'seat_number',
        'student_id',
        'name',
        'name_bn',
        'father_name',
        'mother_name',
        'date_of_birth',
        'nid_or_birth_reg',
        'nationality',
        'marital_status',
        'gender',
        'religion',
        'educational_qualifications',
        'phone',
        'guardian_phone',
        'guardian_name',
        'email',
        'course',
        'duration',
        'admission_date',
        'status',
        'address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'date_of_birth' => 'date',
            'educational_qualifications' => 'array',
        ];
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(ComputerTrainingAttendance::class, 'student_id');
    }

    public function fees(): HasMany
    {
        return $this->hasMany(ComputerTrainingFee::class, 'student_id');
    }

    public function batch()
    {
        return $this->belongsTo(ComputerTrainingBatch::class, 'batch_id');
    }
}
