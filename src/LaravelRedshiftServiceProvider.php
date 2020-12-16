<?php

namespace YuK1\LaravelRedshift;

use Illuminate\Support\ServiceProvider;

class LaravelRedshiftServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('db.factory', function ($app) {
            return new Database\Connectors\ConnectionFactory($app);
        });

        $this->app->singleton('db', function ($app) {
            return new Database\DatabaseManager($app, $app['db.factory']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-redshift'];
    }
}
