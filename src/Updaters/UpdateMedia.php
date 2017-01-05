<?php

namespace Spatie\Blender\Model\Updaters;

use Spatie\MediaLibrary\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

trait UpdateMedia
{
    protected function updateMedia(Model $model, FormRequest $request)
    {
        if (! isset($model->mediaLibraryCollections)) {
            return;
        }

        foreach ($model->mediaLibraryCollections as $collection) {
            if (! $request->has($collection)) {
                continue;
            }

            $updatedMedia = $model->updateMedia(
                json_decode($request->get($collection), true),
                $collection
            );

            collect($updatedMedia)->each(function (Media $media) {
                $media->setCustomProperty('temp', false);
                $media->save();
            });
        }
    }
}
