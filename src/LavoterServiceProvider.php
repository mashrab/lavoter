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
         * Assets
         */
        $this->publishes([
            __DIR__ . '/../public/vendor/lavoter' => public_path('vendor/lavoter'),
        ], 'public');

        /**
         * Views
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lavoter');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Controllers
         */
        $this->app->make('Zvermafia\Lavoter\Controllers\LavoterController');
    }
}
