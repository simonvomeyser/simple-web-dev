<?php

namespace App;

use Faker\Generator as Faker;
use InvalidArgumentException;
use Symfony\Component\Finder\Finder;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\FactoryBuilder;
use stdClass;

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
