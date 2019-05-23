<?php


namespace Laramqp;


class Consumer
{
    protected $connection;

    protected $connectionName;
    protected $exchangeName;
    protected $queueName;

    public function __construct(Connection $connection, $key)
    {
        $this->connection = $connection;
        list($this->connectionName, $this->exchangeName, $this->queueName) = Parser::parseKey($key);
    }
}