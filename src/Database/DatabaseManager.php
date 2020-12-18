<?php
namespace YuK1\LaravelRedshift\Database;

use Illuminate\Database\DatabaseManager as IlluminateDatabaseManager;

class DatabaseManager extends IlluminateDatabaseManager
{
    public function supportedDrivers()
    {
        return array_merge(parent::supportedDrivers(), ['redshift']);
    }
}