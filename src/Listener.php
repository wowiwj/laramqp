<?php


namespace Laramqp;


use Closure;

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
        $channel = $this->connection->getChannel();
        $channel->basic_consume(
            $this->queueName,
            $this->getOptions('consumer_tag', ''),
            $this->getOptions('consumer_no_local', false),
            $this->getOptions('consumer_no_ack', false),
            $this->getOptions('consumer_exclusive', false),
            $this->getOptions('consumer_nowait', false),
            $callback
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

}