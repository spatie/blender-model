<?php

namespace Spatie\Blender\Model\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Blender\Model\Traits\Draftable;
use Spatie\EloquentSortable\Sortable;

class SortableScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (request()->isFront() && $model instanceof Sortable) {
            $builder->orderBy('order_column');
        }
    }
}
