<?php

namespace App\Providers;

use App\FactoryProxy;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('sortByDate', function ($column = 'created_at', $order = SORT_DESC) {
            return $this->sortBy(function ($date) use ($column) {
                return strtotime($date->$column);
            }, SORT_REGULAR, $order == SORT_DESC);
        });
    }
}
