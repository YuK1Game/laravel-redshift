<?php
namespace YuK1\LaravelRedshift\Database\Connectors;

use Illuminate\Database\Connectors\ConnectionFactory as IlluminateConnectionFactory;
use YuK1\LaravelRedshift\Database\RedshiftConnection;

class ConnectionFactory extends IlluminateConnectionFactory
{
    protected function createConnection($driver, $connection, $database, $prefix = '', array $config = [])
    {
        if ($driver === 'redshift') {
            return new RedshiftConnection($connection, $database, $prefix, $config);
        }

        return parent::createConnection($driver, $connection, $database, $prefix, $config);
    }

    public function createConnector(array $config)
    {
        if ($config['driver'] === 'redshift') {
            return new RedshiftConnector;
        }

        return parent::createConnector($config);
    }
}