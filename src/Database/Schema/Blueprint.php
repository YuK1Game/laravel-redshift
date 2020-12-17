<?php
namespace YuK1\LaravelRedshift\Database\Schema;

use Illuminate\Database\Schema\Blueprint as IlluminateBlueprint;
use YuK1\LaravelRedshift\LaravelRedshiftException;

use YuK1\LaravelRedshift\Database\RedshiftConnection as Connection;
use YuK1\LaravelRedshift\Database\Schema\Grammars\RedshiftGrammar as Grammar;

class Blueprint extends IlluminateBlueprint
{
    protected $distStyleType = null;

    protected $distStyleKey = null;


    public function index($columns, $name = null, $algorithm = null)
    {
        throw new LaravelRedshiftException('Redshift does not support index. Sort key and Dist key are supported.');
    }

    public function distStyle($style) {
        return $this->addDistStyle($style);
    }

    public function distKey($key) {
        return $this->addDistStyle('key', $key);
    }

    public function addDistStyle($type, $key = null) {
        if ($this->distStyleType) {
            throw new LaravelRedshiftException('Dist key is already set.');
        }
        $this->distStyleType = $type;
        $this->distStyleKey = $key;
        return $this;
    }

    public function hasSortKeyColumn() {
        return ! is_null(collect($this->getAddedColumns())->first(function ($column) {
            return $column->sortKey !== null;
        }));
    }

    public function sortKeyValues() {
        if ( ! $this->hasSortKeyColumn()) {
            return [];
        }

        return collect($this->getAddedColumns())->mapWithKeys(function ($column) {
            return [ $column->name => $column->sortKey ];
        })->filter()->all();
    }

    public function distKeyValue() {
        return $this->distStyleType ? [ $this->distStyleType, $this->distStyleKey ] : [];
    }

}