<?php

namespace Spatie\Blender\Model\Updaters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

trait UpdateDates
{
    protected function updateDates(Model $model, FormRequest $request)
    {
        foreach ($model->getDates() as $dateAttribute) {
            if ($request->has($dateAttribute)) {
                $model->$dateAttribute = Carbon::createFromFormat('d/m/Y', $request->get($dateAttribute));
            }
        }
    }
}
