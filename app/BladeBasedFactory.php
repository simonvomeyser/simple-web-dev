<?php

namespace App;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\FactoryBuilder;
use InvalidArgumentException;
use stdClass;
use Symfony\Component\Finder\Finder;

class BladeBasedFactoryBuilder extends FactoryBuilder
{
    /**
     * Make an instance of the model with the given attributes.
     *
     * @param  array  $attributes
     * @return \App\BladeBasedModel
     */
    protected function makeInstance(array $attributes = [])
    {
        return new $this->class(
            $this->getRawAttributes($attributes)
        );
    }

    /**
     * Create a collection of models and persist them to the database.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function create(array $attributes = [])
    {
        $results = $this->make($attributes);

        if ($results instanceof BladeBasedModel) {
            $results->save();
        } else {
            $results->each(function ($model) {
                $model->save();
            });
        }

        return $results;
    }
}

class BladeBasedFactory extends Factory
{
    /**
     * The model being built.
     *
     * @var string
     */
    protected $class;

    public function of($class)
    {
        return new BladeBasedFactoryBuilder(
            $class,
            $this->definitions,
            $this->states,
            $this->afterMaking,
            $this->afterCreating,
            $this->faker
        );
    }
}
