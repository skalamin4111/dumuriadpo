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

    protected $appends = ['total_marks'];

    protected static function booted()
    {
        static::created(function ($student) {
            $student->fees()->create([
                'company_id' => $student->company_id,
                'fee_type' => 'Admission Fee',
                'amount' => 3000,
                'paid_amount' => 1000,
                'due_date' => $student->admission_date ?? now(),
                'status' => 'partial',
            ]);
        });
    }

    public function getTotalMarksAttribute(): int
    {
        if (array_key_exists('present_count', $this->attributes)) {
            $p = $this->present_count;
            $a = $this->absent_count;
            $l = $this->late_count;
            $r1 = $this->rank_1_count;
            $r2 = $this->rank_2_count;
            $r3 = $this->rank_3_count;

            if (array_key_exists('advance_absence_count', $this->attributes)) {
                $a -= $this->advance_absence_count;
            }
        } else {
            $p = $this->attendances()->where('status', 'present')->count();
            $a = $this->attendances()->where('status', 'absent')->where('is_advance_absence', false)->count();
            $l = $this->attendances()->where('status', 'late')->count();
            $r1 = $this->attendances()->where('daily_rank', 1)->count();
            $r2 = $this->attendances()->where('daily_rank', 2)->count();
            $r3 = $this->attendances()->where('daily_rank', 3)->count();
        }

        $standardPresent = max(0, $p - $r1 - $r2 - $r3);

        return ($standardPresent * 5) + ($r1 * 10) + ($r2 * 5) + ($r3 * 3) + ($l * 5) - ($a * 2);
    }

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
        'session',
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

    public function advanceAbsences()
    {
        return $this->hasMany(ComputerTrainingAdvanceAbsence::class, 'student_id');
    }
}
