<?php

namespace Spatie\Blender\Model\Traits;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

trait HasTags
{
    public static function getTagClassName(): string
    {
        return \App\Models\Tag::class;
    }

    public function tagsWithType(string $type): Collection
    {
        return $this->tags->filter(function (Tag $tag) use ($type) {
            return $tag->type === $type;
        });
    }
}
