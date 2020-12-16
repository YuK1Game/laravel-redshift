<?php
namespace YuK1\LaravelRedshift\Database\Schema;

use Illuminate\Database\Schema\Blueprint as IlluminateBlueprint;
use YuK1\LaravelRedshift\LaravelRedshiftException;

class Blueprint extends IlluminateBlueprint
{
    public function index($columns, $name = null, $algorithm = null)
    {
        throw new LaravelRedshiftException('Redshift does not support index. Sort key and Dist key are supported.');
    }

    public function sortKey($columns) {
        // TODO: Add a sort key
    }

    public function distKey($columns) {
        // TODO: Add a dist key
    }
}