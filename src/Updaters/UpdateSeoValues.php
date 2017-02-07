<?php

namespace Spatie\Blender\Model\Updaters;

use Spatie\Regex\Regex;
use Spatie\Regex\MatchResult;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

trait UpdateSeoValues
{
    protected function updateSeoValues(Model $model, FormRequest $request)
    {
        $mapWithKeysFunctionName = 'mapWithKeys';

        if (starts_with(app()->version(), '5.3')) {
            $mapWithKeysFunctionName = 'mapToAssoc';
        }

        collect($request->all())
            ->filter(function ($value, $fieldName) {
                // Filter out everything that starts with 'translated_<locale>_seo_'
                return Regex::match('/^translated_([a-z][a-z])_seo_/', $fieldName)->hasMatch();
            })
            ->map(function ($value, $fieldName) {

                // Replace 'translated_<locale>_seo_<attribute>' with '<locale>_<attribute>'
                $localeAndAttribute = Regex::replace('/translated_([a-z][a-z])_seo_/', function (MatchResult $matchResult) {
                    return $matchResult->group(1).'_';
                }, $fieldName)->result();

                $localeAndAttribute = explode('_', $localeAndAttribute, 2);

                return [
                    'locale' => $localeAndAttribute[0],
                    'attribute' => $localeAndAttribute[1],
                    'value' => $value,
                ];
            })
            ->groupBy('locale')
            ->map(function (Collection $valuesInLocale) use ($mapWithKeysFunctionName) {
                return $valuesInLocale->$mapWithKeysFunctionName(function ($values) {
                    return [$values['attribute'], $values['value']];
                });
            })
            ->each(function ($values, $locale) use ($model) {
                $model->setTranslation('seo_values', $locale, $values);
            });
    }
}
