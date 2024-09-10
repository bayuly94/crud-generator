<?php

namespace Bayuly94\CrudGenerator;

use Bayuly94\CrudGenerator\Commands\CrudGenerator;
use Illuminate\Support\ServiceProvider;

/**
 * Class CrudServiceProvider.
 */
class CrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CrudGenerator::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/config/crud.php' => config_path('crud.php'),
        ], 'crud');

        $this->publishes([
            __DIR__.'/../src/stubs' => resource_path('stubs/crud/'),
        ], 'stubs-crud');
        
        
        $this->publishes([
            __DIR__.'/../src/component' => resource_path('vendor/'),
        ], 'crud');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
