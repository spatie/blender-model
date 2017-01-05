<?php

namespace Spatie\Blender\Model;

use Illuminate\Support\ServiceProvider;
use Spatie\Blender\Model\Scopes\NonDraftMediaScope;
use Spatie\MediaLibrary\Media;

class BlenderModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Media::addGlobalScope(new NonDraftMediaScope());
    }
}