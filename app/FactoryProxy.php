<?php

namespace App;

use App\BladeBasedModel;
use Faker\Generator as FakerGenerator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class FactoryProxy
{

    public function __construct(Application $app)
    {
        $this->eloquentFactory = EloquentFactory::construct(
            $app->make(FakerGenerator::class),
            $app->databasePath('factories')
        );
    }

    function of($class)
    {
        if ((new $class) instanceof BladeBasedModel) {
            dd('Defer to bald based factory');
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
