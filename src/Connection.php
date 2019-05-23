<?php


namespace Laramqp;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    protected $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public static function connect($config)
    {
        $connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password'],
            $config['vhost']
        );
        return new self($connection);
    }

    public function getConnect()
    {
        return $this->connection;
    }
}