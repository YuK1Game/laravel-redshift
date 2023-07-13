<?php
namespace YuK1\LaravelRedshift\Database\Query\Grammars;

use Illuminate\Database\Query\Grammars\PostgresGrammar;
use Illuminate\Database\Query\Builder;

class RedshiftGrammar extends PostgresGrammar
{
    /**
     * Compile insert statement.
     * Unlike PostgreSQL, in Redshift it is not possible to return the id at the same time
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array  $values
     * @param  string  $sequence
     * @return string
     */
    public function compileInsertGetId(Builder $query, $values, $sequence)
    {
        return $this->compileInsert($query, $values);
    }
}
