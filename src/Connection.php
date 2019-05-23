<?php


namespace Laramqp;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class Connection extends Optionable
{
    /**
     * @var AMQPStreamConnection
     */
    protected $connection;


    public function __construct($config, $key)
    {
        parent::__construct($config, $key);
        $this->AMQPConnect();
    }

    /**
     * connect and instance connection
     * @param $config
     * @param $key
     * @return Connection
     * @author wangju 19-5-23 上午11:57
     */
    public static function connect($config, $key)
    {
        return new self($config, $key);
    }

    /**
     * connect mq by key
     * @return void
     * @author wangju 19-5-23 上午11:56
     */
    public function AMQPConnect()
    {
        $connection = new AMQPStreamConnection(
            $this->getOptions('host', 'localhost'),
            $this->getOptions('port', 5672),
            $this->getOptions('username', 'guest'),
            $this->getOptions('password', 'guest'),
            $this->getOptions('vhost', '/')
        );
        $this->connection = $connection;
    }


    public function getChannel()
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(
            $this->queueName,
            $this->getOptions('queue_passive', false),
            $this->getOptions('queue_durable', true),
            $this->getOptions('queue_exclusive', false),
            $this->getOptions('queue_auto_delete', false)
        );
        $channel->exchange_declare($this->exchangeName,
            $this->getOptions('exchange_direct', 'direct'),
            $this->getOptions('exchange_passive', false),
            $this->getOptions('exchange_durable', true),
            $this->getOptions('exchange_auto_delete', false)
        );

        if ($this->getOptions('auto_bind', true)) {
            $channel->queue_bind($this->queueName, $this->exchangeName);
        }
        return $channel;
    }

    /**
     * reconnect mq while connection is closed
     * @author wangju 19-5-23 上午11:56
     */
    public function reConnect()
    {
        $this->connection->reconnect();
        return $this;
    }

    /**
     * get mq connection
     * @return AMQPStreamConnection
     * @author wangju 19-5-23 上午11:56
     */
    public function getConnect()
    {
        return $this->connection;
    }

    /**
     * close collection
     * @throws \Exception
     * @author wangju 19-5-23 下午1:36
     */
    public function close()
    {
        return $this->connection->close();
    }
}