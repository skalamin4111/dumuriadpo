<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ComputerTrainingMarketingLead extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'name',
        'phone',
        'interested_course',
        'duration',
        'source',
        'status',
        'call_status',
        'next_follow_up_at',
        'notes',
        'remarks',
    ];

    protected function casts(): array
    {
        return ['next_follow_up_at' => 'datetime'];
    }
}
