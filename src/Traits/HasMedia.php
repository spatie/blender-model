<?php

namespace Spatie\Blender\Model\Traits;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Don't forget to set protected $mediaLibraryCollections.
 */
trait HasMedia
{
    use HasMediaTrait;

    public function mediaLibraryCollectionType(string $name): string
    {
        return $this->mediaLibraryCollections[$name];
    }

    public function mediaLibraryCollectionNames(): array
    {
        return $this->mediaLibraryCollections ?? [];
    }
}
