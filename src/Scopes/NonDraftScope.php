<?php

namespace Spatie\Blender\Model\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Blender\Model\Traits\Draftable;

class NonDraftScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($model instanceof Draftable) {
            $builder->where('draft', false);
        }
    }
}