<?php


namespace Laramqp;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection
{
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;
    protected $config;

    protected $connectionName;
    protected $exchangeName;
    protected $queueName;

    public function __construct($config, $key)
    {
        $this->config = $config;
        $this->connectByKey($key);
    }

    public static function connect($config, $key)
    {
        return new self($config, $key);
    }

    public function connectByKey($key)
    {
        list($this->connectionName, $this->exchangeName, $this->queueName) = Parser::parseKey($key);
        $config = $this->config['connections'][$this->connectionName];
        $connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['username'],
            $config['password'],
            $config['vhost']
        );
        $this->connection = $connection;
        return $this;
    }

    public function getConnect()
    {
        return $this->connection;
    }
}