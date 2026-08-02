<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerTrainingBatch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'capacity',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(ComputerTrainingStudent::class, 'batch_id');
    }
}
