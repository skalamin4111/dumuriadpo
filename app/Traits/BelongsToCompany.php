<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany(): void
    {
        static::creating(function ($model) {
            if (! $model->company_id && app()->bound('tenant.company_id')) {
                $model->company_id = app('tenant.company_id');
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (app()->bound('tenant.company_id')) {
                $builder->where($builder->getModel()->getTable().'.company_id', app('tenant.company_id'));
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
