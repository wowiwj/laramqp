<?php


namespace Laramqp;


use Closure;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Listener extends Optionable
{
    protected $connection;

    protected $connectionName;
    protected $exchangeName;
    protected $queueName;

    public function __construct($config, $key)
    {
        parent::__construct($config, $key);
        $this->connection = Connection::connect($config, $key);
    }

    public function listen(Closure $callback)
    {
        $connect = $this->connection->getConnect();



        $channel = $connect->channel();

        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->exchange_declare($this->exchangeName, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queueName, $this->exchangeName);

        $channel->basic_consume($this->queueName, 'test', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

}