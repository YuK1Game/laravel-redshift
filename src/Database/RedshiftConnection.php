<?php
namespace YuK1\LaravelRedshift\Database;

use Illuminate\Database\PostgresConnection;

use YuK1\LaravelRedshift\Database\Query\Grammars\RedshiftGrammar as QueryGrammar;
use YuK1\LaravelRedshift\Database\Query\Processors\RedshiftProcessor;
use YuK1\LaravelRedshift\Database\Schema\Grammars\RedshiftGrammar as SchemaGrammar;
use YuK1\LaravelRedshift\Database\Schema\RedshiftBuilder;
use YuK1\LaravelRedshift\Database\Schema\RedshiftSchemaState;
use Illuminate\Database\Filesystem;

class RedshiftConnection extends PostgresConnection
{
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new RedshiftBuilder($this);
    }

    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    public function getSchemaState(Filesystem $files = null, callable $processFactory = null)
    {
        return new RedshiftSchemaState($this, $files, $processFactory);
    }

    protected function getDefaultPostProcessor()
    {
        return new RedshiftProcessor;
    }

}