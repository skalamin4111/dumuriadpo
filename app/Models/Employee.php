<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToCompany;

class Employee extends Model
{
    use BelongsToCompany;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'department_id',
        'employee_code',
        'designation',
        'joining_date',
        'phone',
        'address',
        'emergency_contact',
        'profile_photo_path',
        'status',
    ];

    protected function casts(): array
    {
        return ['joining_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_employee_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }
}
