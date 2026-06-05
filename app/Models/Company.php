<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['uuid', 'name', 'slug', 'domain', 'plan', 'status', 'timezone', 'locale', 'settings'];

    protected function casts(): array
    {
        return ['settings' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(function (Company $company) {
            $company->uuid ??= (string) Str::uuid();
            $company->slug ??= Str::slug($company->name);
        });
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
