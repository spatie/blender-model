<?php

namespace Spatie\Blender\Model\Traits;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Don't forget to set protected $mediaLibraryCollections.
 */
trait HasMedia
{
    use HasMediaTrait;

    public function mediaLibraryCollections(): array
    {
        return $this->mediaLibraryCollections ?? [];
    }
}
