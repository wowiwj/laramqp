<?php


namespace Laramqp;


use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Publisher
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

    /**
     * add message to exchange
     * @param $message
     * @return bool
     * @throws \Exception
     * @author wangju 19-5-23 下午1:38
     */
    public function add($message)
    {
        $connect = $this->connection->getConnect();
        $channel = $connect->channel();
        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->exchange_declare($this->exchangeName, AMQPExchangeType::DIRECT, false, true, false);
        $channel->queue_bind($this->queueName, $this->exchangeName);

        $message = $this->convertMessage($message);
        $amqpMessage = new AMQPMessage($message, [
            'content_type'  => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ]);
        $channel->basic_publish($amqpMessage, $this->exchangeName);
        $channel->close();
        $this->connection->close();
        return true;
    }

    /**
     * convert message with string
     * @param $message
     * @return false|string
     * @author wangju 19-5-23 下午1:41
     */
    public function convertMessage($message)
    {
        if (is_array($message)) {
            return json_encode($message, true);
        }
        return $message;
    }
}