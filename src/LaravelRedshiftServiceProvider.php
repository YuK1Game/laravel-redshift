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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'yuk1');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'yuk1');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-redshift.php', 'laravel-redshift');

        // Register the service the package provides.
        $this->app->singleton('laravel-redshift', function ($app) {
            return new LaravelRedshift;
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

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravel-redshift.php' => config_path('laravel-redshift.php'),
        ], 'laravel-redshift.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/yuk1'),
        ], 'laravel-redshift.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/yuk1'),
        ], 'laravel-redshift.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/yuk1'),
        ], 'laravel-redshift.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
