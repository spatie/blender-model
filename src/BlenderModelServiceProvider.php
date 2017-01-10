<?php

namespace Spatie\Blender\Model;

use Spatie\MediaLibrary\Media;
use Illuminate\Support\ServiceProvider;
use Spatie\Blender\Model\Scopes\SortableScope;
use Spatie\Blender\Model\Scopes\NonDraftMediaScope;

class BlenderModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Media::addGlobalScope(new NonDraftMediaScope());
        Media::addGlobalScope(new SortableScope());
    }
}
