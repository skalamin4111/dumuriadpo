<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class EscalationRule extends Model
{
    use BelongsToCompany;

    protected $fillable = ['company_id', 'name', 'minutes_after_due', 'notify_role', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
