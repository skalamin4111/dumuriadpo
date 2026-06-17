<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerTrainingBatch extends Model
{
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
