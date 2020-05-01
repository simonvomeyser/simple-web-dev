<?php

namespace App;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class BladeBasedModel implements Responsable
{
    use ForwardsCalls;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    public $exists = false;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->newQuery(), $method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function save()
    {
        // todo: loop over dynamic attributes
        $replace = [
            '{{ title }}' => $this->title,

            '{{ release_date }}' => $this->release_date ?? Date::now(),

            '{{ slugs }}' => json_encode($this->slugs) ?? '[]',

            '{{ tags }}' => json_encode($this->tags) ?? '[]',

            '{{ excerpt }}' => $this->excerpt ?? '',

            '{{ header_image }}' => $this->header_image ?? 'https://placehold.it/1024x768',

            '{{ list_header_image }}' => $this->list_header_image ?? 'https://placehold.it/600x300',

            '{{ content }}' => $this->content ?? '',
        ];

        $stub = File::get($this->getStub());

        $replacedStub = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );

        File::put($this->getViewFolder().'/'.$this->getFilename().'.blade.php', $replacedStub);
        $this->exists = true;
    }

    public function getStub(): string
    {
        return app_path('Stubs/Post.stub'); // todo make dynamic, read from name or var
    }

    public function getFilename(): string
    {
        return Hash::make();
    }

    public function view(): string
    {
        if (! $this->exists) {
            return false;
        }

        return view($this->lowerBaseName().'.'.$this->getFilename());
    }

    public function baseName(): string
    {
        return class_basename(new static);
    }

    public function lowerBaseName(): string
    {
        return strtolower($this->baseName());
    }

    public function getViewFolder(): string
    {
        // todo, find a better way to to this, mock this, create fake files in memory?
        if (env('APP_ENV') === 'testing') {
            return base_path('tests/Fixtures/'.$this->lowerBaseName());
        }

        return resource_path('views/'.$this->lowerBaseName());
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }

        return $this;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    public function newQuery()
    {
        return new ViewQueryBuilder(new static);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return new Response($this->view()) ?? abort(404);
    }
}
