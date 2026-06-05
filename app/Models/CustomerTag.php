<?php

namespace App\Models;

use App\Traits\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;

class CustomerTag extends Model
{
    use BelongsToCompany;

    protected $fillable = ['company_id', 'name', 'color'];
}
