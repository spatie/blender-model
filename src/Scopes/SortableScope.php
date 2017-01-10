<?php

namespace Spatie\Blender\Model\Scopes;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SortableScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (request()->isFront() && $model instanceof Sortable) {
            $builder->orderBy('order_column');
        }
    }
}
