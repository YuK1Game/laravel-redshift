<?php
namespace YuK1\LaravelRedshift\Database\Query\Processors;

use Illuminate\Database\Query\Processors\PostgresProcessor;
use Illuminate\Database\Query\Builder;

class RedshiftProcessor extends PostgresProcessor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $sql
     * @param  array  $values
     * @param  string|null  $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $connection = $query->getConnection();

        $connection->insert($sql, $values);

        $idColumn = $sequence ?: 'id';
        $wrappedTable = $query->getGrammar()->wrapTable($query->from);
        $result = $connection->selectOne('select max('. $idColumn .') from '.$wrappedTable);
        $id = array_values((array) $result)[0];

        return is_numeric($id) ? (int) $id : $id;
    }
}
