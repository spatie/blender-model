<?php

namespace Spatie\Blender\Model\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class NonDraftMediaScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (request()->isFront()) {
            $builder
                ->whereRaw('NOT json_contains_path(`custom_properties` ,"one", "$.draft")')
                ->orWhere('custom_properties->draft', false);
        }
    }
}
