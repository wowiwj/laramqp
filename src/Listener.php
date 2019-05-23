<?php


namespace Laramqp;


use Closure;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Listener
{
    protected $connection;

    protected $connectionName;
    protected $exchangeName;
    protected $queueName;

    public function __construct(Connection $connection, $key)
    {
        $this->connection = $connection;
        $this->parseKey($key);
    }

    protected function parseKey($key)
    {
        $keyArr = explode('.', $key);
        if (count($keyArr) != 3) {
            new \Exception("parsed error by key: " . $key);
        }
        list($this->connectionName, $this->exchangeName, $this->queueName) = $keyArr;
    }

    public function listen(Closure $callback)
    {
        $connect = $this->connection->getConnect();
        $channel =$connect->channel();
        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->exchange_declare($this->exchangeName, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queueName, $this->exchangeName);
        $channel->basic_consume($this->queueName,'test');
    }
}