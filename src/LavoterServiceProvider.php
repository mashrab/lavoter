<?php

namespace Zvermafia\Lavoter;

use Illuminate\Support\ServiceProvider;

class LavoterServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $packageName = 'lavoter';
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Config
         */
        $this->publishes([
            __DIR__ . '/config/lavoter.php' => config_path('lavoter.php'),
        ]);

        /**
         * Migrations
         */
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'migrations');
        
        /**
         * Routes
         */
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }

        /**
         * Views
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lavoter');
        
        /**
         * Assets
         */
        $this->publishes([
            __DIR__ . '/../public/vendor/lavoter' => public_path('vendor/lavoter'),
        ], 'public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Merge config
         */
        $this->mergeConfigFrom(
            __DIR__ . '/config/lavoter.php', 'lavoter'
        );

        /**
         * Controllers
         */
        $this->app->make('Zvermafia\Lavoter\Controllers\LavoterController');
    }
}
