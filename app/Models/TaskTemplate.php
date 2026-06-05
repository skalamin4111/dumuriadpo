<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTemplate extends Model
{
    use BelongsToCompany;
    use SoftDeletes;

    protected $fillable = ['company_id', 'name', 'description', 'priority', 'default_sla_minutes', 'checklist', 'is_active'];

    protected function casts(): array
    {
        return ['checklist' => 'array', 'is_active' => 'boolean'];
    }
}
