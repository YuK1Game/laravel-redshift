<?php
namespace YuK1\LaravelRedshift\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Fluent;
use YuK1\LaravelRedshift\LaravelRedshiftException;

class RedshiftGrammar extends PostgresGrammar
{
    protected function generatableColumn($type, Fluent $column)
    {
        if (! $column->autoIncrement && is_null($column->generatedAs)) {
            return $type;
        }

        if ($column->autoIncrement && is_null($column->generatedAs)) {
            return with([
                'integer' => 'INTEGER',
                'bigint' => 'BIGINT',
                'smallint' => 'SMALLINT',
            ])[$type];
        }

        return parent::generatableColumn($type, $column);
    }

    protected function typeTimestamp(Fluent $column)
    {
        $columnType = 'timestamp without time zone';

        return $column->useCurrent ? "$columnType default CURRENT_TIMESTAMP" : $columnType;
    }

    protected function modifyIncrement(Blueprint $blueprint, Fluent $column)
    {
        if ((in_array($column->type, $this->serials) || ($column->generatedAs !== null)) && $column->autoIncrement) {
            return ' identity(1,1)';
        }
    }

    public function compileCreate(Blueprint $blueprint, Fluent $command)
    {
        return array_values(array_filter(array_merge([sprintf('%s table %s (%s)',
                $blueprint->temporary ? 'create temporary' : 'create',
                $this->wrapTable($blueprint),
                implode(', ', $this->getColumns($blueprint)),
            )],
            $this->compileAlter($blueprint)
        )));
    }

    protected function compileAlter(Blueprint $blueprint)
    {
        $distKey = $this->compileDistKey($blueprint);
        $sortKey = $this->compileSortKey($blueprint);
        $keys = collect([ $distKey, $sortKey ])->flatten()->filter()->values();
        
        return $keys->map(function($key) use($blueprint) {
            return sprintf('alter table %s %s', $blueprint->getTable(), $key);
        })
        ->values()->all();
    }

    protected function compileSortKey(Blueprint $blueprint)
    {
        if ($values = $blueprint->sortKeyValues()) {
            return sprintf('alter compound sortkey (%s)',
                    collect($values)->sort()->keys()->map(function($value) {
                        return '"' . $value . '"';
                    })
                    ->join(', '));
        }
        return null;
    }

    protected function compileDistKey(Blueprint $blueprint)
    {
        if ($distKeyColumn = $blueprint->distKeyValue()) {
            $distKeyColumn = collect($distKeyColumn);
            
            switch ($distKeyColumn[0]) {
                case 'key':
                    return sprintf('alter diststyle key distkey %s', $distKeyColumn[1]);
                case 'all':
                case 'auto':
                case 'even':
                    return sprintf('alter diststyle %s', $distKeyColumn[0]);
                default:
                    throw new LaravelRedshiftException(sprintf('Dist key name "%s" is not supported.', $distKeyColumn[0]));
                    
            }
        }
        return null;
    }

}