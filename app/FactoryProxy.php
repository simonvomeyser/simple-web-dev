<?php

namespace App;

use App\BladeBasedModel;
use Faker\Generator as FakerGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class FactoryProxy
{
    public $elequentFactory;
    public $bladeBasedFactory;

    public function __construct(Application $app)
    {
        $this->eloquentFactory = EloquentFactory::construct(
            $app->make(FakerGenerator::class),
            $app->databasePath('factories')
        );

        $this->bladeBasedFactory = BladeBasedFactory::construct(
            $app->make(FakerGenerator::class),
            $app->databasePath('factories')
        );
    }

    function of($class)
    {
        if ((new $class) instanceof BladeBasedModel) {
            return $this->bladeBasedFactory->of($class);
        }
        return $this->eloquentFactory->of($class);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->eloquentFactory->$method(...$parameters);
    }
}
