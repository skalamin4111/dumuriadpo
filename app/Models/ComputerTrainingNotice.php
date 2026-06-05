<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ComputerTrainingNotice extends Model
{
    use BelongsToCompany;

    protected $fillable = [
        'company_id',
        'title',
        'body',
        'publish_date',
        'audience',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'publish_date' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
