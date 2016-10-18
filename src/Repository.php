<?php

namespace Spatie\Blender\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

abstract class Repository
{
    public function save(Eloquent $model): bool
    {
        $saved = $model->save();

        if ($saved) {
            Cache::flush();
        }

        return $saved;
    }

    public function delete(Eloquent $model): bool
    {
        $deleted = $model->delete();

        if ($deleted) {
            Cache::flush();
        }

        return $deleted;
    }

    public function getAll(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id)
    {
        return $this->query()->find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findOnline(int $id)
    {
        return $this->query()->online()->find($id);
    }

    public function getAllOnline(): Collection
    {
        return $this->query()
            ->online()
            ->get();
    }

    /**
     * @param string $url
     * @param array  $with
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findByUrl(string $url, array $with = [])
    {
        $model = static::MODEL;

        $locale = content_locale();

        if (! isset((new $model())->translatedAttributes)) {
            return $this->query()
                ->online()
                ->where('url', 'regexp', "\"{$locale}\"\s*:\s*\"{$url}\"")
                ->first();
        }

        return $this->query()
            ->with($with)
            ->online()
            ->whereTranslation('url', $url, $locale)
            ->first();
    }

    protected function query()
    {
        return call_user_func(static::MODEL.'::query');
    }
}
