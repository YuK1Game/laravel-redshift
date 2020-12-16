<?php
namespace YuK1\LaravelRedshift\Database\Schema\Grammars;

use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Fluent;

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

        $options = '';

        if (! is_bool($column->generatedAs) && ! empty($column->generatedAs)) {
            $options = sprintf(' (%s)', $column->generatedAs);
        }

        return sprintf(
            '%s generated %s as identity%s',
            $type,
            $column->always ? 'always' : 'by default',
            $options
        );
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
}