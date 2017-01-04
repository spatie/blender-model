<?php

namespace Spatie\Blender\Model\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Blender\Model\Traits\Draftable;

class NonDraftScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (in_array(Draftable::class, class_uses_recursive($model))) {
            $builder->where('draft', false);
        }
    }
}
