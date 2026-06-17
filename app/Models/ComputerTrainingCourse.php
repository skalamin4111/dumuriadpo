<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerTrainingCourse extends Model
{
    use BelongsToCompany, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'duration',
        'fee',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(ComputerTrainingStudent::class, 'course', 'name');
    }
}
