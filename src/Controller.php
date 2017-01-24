<?php

namespace Spatie\Blender\Model;

use ReflectionClass;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Blender\Model\Scopes\NonDraftScope;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Controller
{
    use Updaters\UpdateMedia;
    use Updaters\UpdateOnlineToggle;
    use Updaters\UpdateDates;
    use Updaters\UpdateSeoValues;
    use Updaters\UpdateTags;
    use Updaters\UpdateTranslations;

    /** @var string */
    protected $modelClass, $moduleName;

    /** @var bool */
    protected $redirectToIndex = false;

    public function __construct()
    {
        $this->modelClass = $this->determineModelClass();
        $this->moduleName = $this->determineModuleName();
    }

    public function index()
    {
        $models = $this->all();

        return view("back.{$this->moduleName}.index")->with('models', $models);
    }

    public function create(...$arguments)
    {
        $model = $this->make(...$arguments);

        return redirect()->to($this->action('edit', $model->id));
    }

    public function show($id)
    {
        return redirect()->to($this->action('edit', $id));
    }

    public function edit(int $id)
    {
        $model = $this->find($id);

        return view("back.{$this->moduleName}.edit")
            ->with('model', $model)
            ->with('module', $this->moduleName);
    }

    public function update(int $id)
    {
        $formRequest = $this->determineUpdateRequestClass();

        $request = app()->make($formRequest);

        $model = $this->find($id);

        $this->updateFromRequest($model, $request);

        Cache::flush();

        $eventDescription = $this->updatedEventDescriptionFor($model);
        activity()->on($model)->log($eventDescription);
        flash()->success(strip_tags($eventDescription));

        return redirect()->to(
            $this->redirectToIndex ? $this->action('index') : $this->action('edit', $model->id)
        );
    }

    public function destroy($id)
    {
        $model = $this->find($id);

        $eventDescription = $this->deletedEventDescriptionFor($model);
        activity()->log($eventDescription);
        flash()->success(strip_tags($eventDescription));

        $model->delete();

        Cache::flush();

        return redirect()->to($this->action('index'));
    }

    public function changeOrder()
    {
        call_user_func([$this->modelClass, 'setNewOrder'], request('ids'));

        Cache::flush();
    }

    protected function find(int $id): Eloquent
    {
        return call_user_func([$this->modelClass, 'where'], 'id', $id)
            ->withoutGlobalScope(NonDraftScope::class)
            ->firstOrFail();
    }

    protected function all(): Collection
    {
        return call_user_func([$this->modelClass, 'all']);
    }

    protected function determineModelClass(): string
    {
        return (new ReflectionClass($this))
            ->getMethod('make')
            ->getReturnType();
    }

    protected function determineModuleName(): string
    {
        return lcfirst(str_replace_last('Controller', '', class_basename($this)));
    }

    protected function determineUpdateRequestClass(): string
    {
        return (new ReflectionClass($this))
            ->getMethod('updateFromRequest')
            ->getParameters()[1]
            ->getClass()
            ->getName();
    }

    protected function updateModel(Eloquent $model, FormRequest $request)
    {
        $this->updateTranslations($model, $request);
        $this->updateMedia($model, $request);
        $this->updateOnlineToggle($model, $request);
        $this->updateDates($model, $request);
        $this->updateSeoValues($model, $request);

        $model->save();
    }

    protected function updateFields(Eloquent $model, FormRequest $request, array $fields)
    {
        collect($fields)->each(function ($field) use ($model, $request) {
            $model->$field = $request->get($field, false);
        });
    }

    protected function updatedEventDescriptionFor(Eloquent $model): string
    {
        $modelName = fragment("back.{$this->moduleName}.singular");

        $linkToModel = el('a', ['href' => $this->action('edit', $model->id)], $model->name);

        if ($model->wasDraft) {
            return fragment('back.events.created', ['model' => $modelName, 'name' => $linkToModel]);
        }

        return fragment('back.events.updated', ['model' => $modelName, 'name' => $linkToModel]);
    }

    protected function deletedEventDescriptionFor(Eloquent $model): string
    {
        $modelName = fragment("back.{$this->moduleName}.singular");

        return fragment('back.events.deleted', ['model' => $modelName, 'name' => $model->name]);
    }

    protected function action(string $action, $parameters = []): string
    {
        return action('\\'.static::class.'@'.$action, $parameters);
    }
}
