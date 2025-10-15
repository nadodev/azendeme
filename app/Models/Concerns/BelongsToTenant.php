<?php

namespace App\Models\Concerns;

use App\Support\Tenancy;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenantId = Tenancy::tenantId();
            if ($tenantId) {
                $builder->where($builder->getModel()->getTable() . '.professional_id', $tenantId);
            }
        });

        static::creating(function ($model) {
            $tenantId = Tenancy::tenantId();
            if ($tenantId && empty($model->professional_id)) {
                $model->professional_id = $tenantId;
            }
        });
    }
}
