<?php

namespace YuK1\LaravelRedshift\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelRedshift extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-redshift';
    }
}
