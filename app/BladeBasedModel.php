<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class BladeBasedModel
{

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public static function all()
    {
        return (new ViewQueryBuilder(new self))->all();
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

    function save()
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

        File::put($this->getViewFolder() . '/' . $this->getFilename() . '.blade.php', $replacedStub);
    }

    function getStub(): string
    {
        return app_path('Stubs/Post.stub'); // todo make dynamic, read from name or var
    }

    function getFilename(): string
    {
        return Hash::make();
    }

    function getViewFolder(): string
    {
        return config('posts.location', resource_path('views/posts')); // todo make dynamic, read from name or var
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
}