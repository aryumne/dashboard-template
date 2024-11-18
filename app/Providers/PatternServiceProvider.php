<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PatternServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $models = config('pattern.models');
        // foreach ($models as $model => $bindings) {
        //     $this->app->bind($bindings['repository'], function ($app) use ($model, $bindings) {
        //         $modelClass = 'App\\Models\\' . $model;
        //         return new $bindings['repository'](new $modelClass);
        //     });

        //     $this->app->bind($bindings['service'], function ($app) use ($bindings) {
        //         return new $bindings['service']($app->make($bindings['repository']));
        //     });
        // }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
