<?php
namespace YuK1\LaravelRedshift\Database\Schema;

use Illuminate\Database\Schema\PostgresBuilder;

use YuK1\LaravelRedshift\Database\Schema\Blueprint;
use Closure;

class RedshiftBuilder extends PostgresBuilder
{
    protected function createBlueprint($table, Closure $callback = null)
    {
        $prefix = $this->connection->getConfig('prefix_indexes')
                    ? $this->connection->getConfig('prefix')
                    : '';

        if (isset($this->resolver)) {
            return call_user_func($this->resolver, $table, $callback, $prefix);
        }

        return new Blueprint($table, $callback, $prefix);
    }
}