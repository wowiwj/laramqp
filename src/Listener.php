<?php


namespace Laramqp;


use Closure;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class Listener
{
    protected $connection;

    protected $connectionName;
    protected $exchangeName;
    protected $queueName;

    public function __construct(Connection $connection, $keyValue)
    {
        $this->connection = $connection;
        list($this->connectionName, $this->exchangeName, $this->queueName) = Parser::parseKey($keyValue);
    }

    public function listen(Closure $callback)
    {
        $connect = $this->connection->getConnect();
        $channel = $connect->channel();
        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->exchange_declare($this->exchangeName, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queueName, $this->exchangeName);
        $channel->basic_consume($this->queueName, 'test', false, false, false, false, $callback);
        $this->wait($channel);
    }

    public function wait(AMQPChannel $channel){
        while ($channel ->is_consuming()) {
            $channel->wait();
        }
    }
}