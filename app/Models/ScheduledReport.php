<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class ScheduledReport extends Model
{
    use BelongsToCompany;

    protected $fillable = ['company_id', 'created_by', 'name', 'report_type', 'filters', 'frequency', 'recipients', 'next_run_at', 'is_active'];

    protected function casts(): array
    {
        return ['filters' => 'array', 'recipients' => 'array', 'next_run_at' => 'datetime', 'is_active' => 'boolean'];
    }
}
