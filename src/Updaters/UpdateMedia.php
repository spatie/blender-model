<?php

namespace Spatie\Blender\Model\Updaters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\MediaLibrary\Media;

trait UpdateMedia
{
    protected function updateMedia(Model $model, FormRequest $request)
    {
        foreach ($model->mediaLibraryCollections() as $collection) {
            if (! $request->has($collection)) {
                continue;
            }

            $updatedMedia = $model->updateMedia(
                $this->convertKeysToSnakeCase(json_decode($request->get($collection), true)),
                $collection
            );

            collect($updatedMedia)->each(function (Media $media) {
                $media->setCustomProperty('temp', false);
                $media->save();
            });
        }
    }

    protected function convertKeysToSnakeCase(array $array): array
    {
        return collect($array)->map(function($mediaProperties) {
            return collect($mediaProperties)->keyBy(function($value, $key) {
                return snake_case($key);
            });
        })->toArray();
    }
}
