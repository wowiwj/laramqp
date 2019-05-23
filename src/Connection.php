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
     * @param $key
     * @return $this
     * @throws \Exception
     * @author wangju 19-5-23 上午11:56
     */
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
    public function close(){
        return $this->connection->close();
    }
}