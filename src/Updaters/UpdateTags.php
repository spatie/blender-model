<?php

namespace Spatie\Blender\Model\Updaters;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

trait UpdateTags
{
    public function updateTags(Model $model, FormRequest $request)
    {
        $model->tags()->detach();

        foreach ($model->tagTypes as $type) {
            collect($request->get("{$type}_tags"))->each(function ($name) use ($model, $type) {
                $tag = Tag::findOrCreate($name, $type);

                $model->tags()->attach($tag);
            });
        }
    }
}
