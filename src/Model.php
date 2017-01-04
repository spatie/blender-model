<?php

namespace Spatie\Blender\Model;

use Spatie\Blender\Model\Scopes\NonDraftScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Spatie\Blender\Model\Scopes\OnlineScope;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\ModelCleanup\GetsCleanedUp;
use Spatie\Translatable\HasTranslations;

abstract class Model extends Eloquent implements HasMediaConversions, GetsCleanedUp
{
    use HasTranslations;
    use Traits\Draftable;
    use Traits\HasMedia;
    use Traits\HasSeoValues;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new NonDraftScope());

        if (! request()->isBack()) {
            static::addGlobalScope(new OnlineScope());
        }
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('admin')
            ->setWidth(368)
            ->setHeight(232)
            ->nonQueued();

        $this->addMediaConversion('redactor')
            ->setWidth(368)
            ->setHeight(232)
            ->nonQueued();
    }

    public static function cleanUp(Builder $query): Builder
    {
        return $query
            ->draft()
            ->where('created_at', '<', Carbon::now()->subWeek());
    }

    public function defaultSeoValues(): array
    {
        return [
            'title' => $this->name,
            'meta_description' => (string) string($this->text)->tease(155),
            'meta_og:title' => $this->name,
            'meta_og:type' => 'website',
            'meta_og:description' => (string) string($this->text)->tease(155),
            'meta_og:image' => $this->hasMedia('images') ?
                url($this->getFirstMediaUrl('images')) :
                url('/images/og-image.png'),
        ];
    }
}
