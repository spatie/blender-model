<?php

namespace Spatie\Blender\Model\Traits;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Media;

/**
 * Don't forget to set protected $mediaLibraryCollections.
 */
trait HasMedia
{
    use HasMediaTrait {
        getMedia as traitGetMedia;
    }

    public function mediaLibraryCollectionType(string $name): string
    {
        return $this->mediaLibraryCollections[$name];
    }

    public function mediaLibraryCollectionNames(): array
    {
        return $this->mediaLibraryCollections ?? [];
    }

    public function getMedia(string $collectionName = '', $filters = []): Collection
    {
        $media = $this->traitGetMedia($collectionName, $filters);

        if (request()->isFront()) {
            $media = $media->reject(function (Media $media) {
                return $media->getCustomProperty('temp', false);
            });
        }

        return $media;
    }
}
